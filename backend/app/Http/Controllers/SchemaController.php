<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchemaRequest;
use App\Http\Requests\UpdateSchemaRequest;
use App\Models\Schema;
use App\Models\SchemaField;
use App\Models\SchemaType;
use App\Services\SchemaValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 


class SchemaController extends Controller
{
    public function index(Request $request)
    {
        $schemas = Schema::with('schemaType')
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('schemaType', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->when($request->type, function ($query, $type) {
                return $query->whereHas('schemaType', function ($q) use ($type) {
                    $q->where('type_key', $type);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $schemaTypes = SchemaType::where('is_active', true)->get(['id', 'name', 'type_key']);

        return Inertia::render('Schemas/Index', [
            'schemas' => $schemas,
            'schemaTypes' => $schemaTypes,
            'filters' => $request->only(['search', 'type'])
        ]);
    }

    public function create()
    {
        $schemaTypes = SchemaType::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'type_key', 'description', 'required_fields']);

        return Inertia::render('Schemas/Create', [
            'schemaTypes' => $schemaTypes
        ]);
    }

    public function store(StoreSchemaRequest $request)
    {
        $schema = Schema::create($request->validated());

        // Pre-populate fields from the schema type templates
        if ($schema->schemaType && !empty($schema->schemaType->required_fields)) {
            $defaultData = $schema->schemaType->required_fields;
            if (is_array($defaultData)) {
                // Remove standard @context if it's already handled by the generator
                unset($defaultData['@context']);
                
                $this->createFieldsFromData($schema->id, null, $defaultData);
            }
        }

        return redirect()->route('schemas.edit', $schema)
            ->with('message', 'Schema created successfully with default SEO fields!');
    }

    private function createFieldsFromData($schemaId, $parentId, array $data)
    {
        $index = 0;
        foreach ($data as $key => $value) {
            $type = 'text';
            $val = null;
            $children = [];

            if (is_array($value)) {
                // Check if it's a "list" of items (associative array check)
                if (array_keys($value) === range(0, count($value) - 1)) {
                    $type = 'array';
                    $children = $value;
                } else {
                    $type = 'object';
                    $children = $value;
                }
            } elseif (is_numeric($value)) {
                $type = 'number';
                $val = $value;
            } elseif (is_bool($value)) {
                $type = 'boolean';
                $val = $value ? 'true' : 'false';
            } else {
                $type = 'text';
                $val = $value;
            }

            $field = SchemaField::create([
                'schema_id' => $schemaId,
                'parent_field_id' => $parentId,
                'field_path' => $key,
                'field_type' => $type,
                'field_value' => $val,
                'sort_order' => $index++
            ]);

            if (!empty($children)) {
                $this->createFieldsFromData($schemaId, $field->id, $children);
            }
        }
    }

    public function show(Schema $schema)
    {
        $schema->load(['schemaType', 'fields.children']);

        return Inertia::render('Schemas/Show', [
            'schema' => $schema,
            'jsonLd' => $schema->toJsonLd(),
            'validation' => $schema->validateSchema()
        ]);
    }

    public function edit(Schema $schema)
    {
        $schema->load(['schemaType', 'fields.children']);
        $schemaTypes = SchemaType::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'type_key', 'description', 'required_fields']);

        return Inertia::render('Schemas/Edit', [
            'schema' => $schema,
            'schemaTypes' => $schemaTypes
        ]);
    }

    public function update(UpdateSchemaRequest $request, Schema $schema)
    {
        $schema->update($request->validated());

        return back()->with('message', 'Schema updated successfully!');
    }

    public function destroy(Schema $schema)
    {
        $schema->delete();

        return redirect()->route('schemas.index')
            ->with('message', 'Schema deleted successfully!');
    }

    public function preview(Schema $schema)
    {
        $schema->load(['schemaType', 'fields.children']);
        
        return response()->json($schema->toJsonLd());
    }

    public function export(Schema $schema)
    {
        $schema->load(['schemaType', 'fields.children']);
        $json = json_encode($schema->toJsonLd(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        return response($json)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="schema-' . $schema->id . '.json"');
    }

    public function validate(Schema $schema)
    {
        $schema->load(['schemaType', 'fields.children']);
        $validation = $schema->validateSchema();
        
        return response()->json([
            'schema_id' => $schema->id,
            'is_valid' => $validation['isValid'],
            'errors' => $validation['errors'],
            'warnings' => $validation['warnings'],
            'json_ld' => $schema->toJsonLd()
        ]);
    }

    public function testWithGoogle(Schema $schema)
    {
        $schema->load(['schemaType', 'fields.children']);
        $jsonLd = $schema->toJsonLd();
        
        // Generate Google Rich Results Test URL
        $testUrl = 'https://search.google.com/test/rich-results';
        
        return response()->json([
            'schema_id' => $schema->id,
            'json_ld' => $jsonLd,
            'test_url' => $testUrl,
            'validation' => $schema->validateSchema(),
            'google_test_instructions' => [
                '1. Copy the JSON-LD from the "json_ld" field',
                '2. Visit the Google Rich Results Test URL',
                '3. Paste the JSON-LD in the "Code Snippet" tab',
                '4. Click "TEST CODE" to validate'
            ]
        ]);
    }

    public function bulkUpdateFields(Request $request, Schema $schema)
    {
        $request->validate([
            'fields' => 'required|array'
        ]);

        // Transaction to ensure data integrity
        DB::transaction(function () use ($schema, $request) {
            // Delete existing fields (cascade will handle children)
            $schema->fields()->whereNull('parent_field_id')->delete();
            
            // Re-create fields recursively
            $this->createFields($schema->id, null, $request->fields);
        });

        return back()->with('message', 'Schema fields updated successfully!');
    }

    private function createFields($schemaId, $parentId, array $fields)
    {
        foreach ($fields as $index => $fieldData) {
            $field = SchemaField::create([
                'schema_id' => $schemaId,
                'parent_field_id' => $parentId,
                'field_path' => $fieldData['field_path'],
                'field_type' => $fieldData['field_type'],
                'field_value' => $fieldData['field_value'] ?? null,
                'field_config' => $fieldData['field_config'] ?? null,
                'sort_order' => $index
            ]);

            // If it has children (nested object/array items)
            if (!empty($fieldData['children']) && is_array($fieldData['children'])) {
                $this->createFields($schemaId, $field->id, $fieldData['children']);
            }
        }
    }

    public function getRequiredFields(SchemaType $schemaType)
    {
        $validationService = new SchemaValidationService();
        
        $rules = $validationService->getValidationRules($schemaType->name);
        
        return response()->json([
            'schema_type' => $schemaType->name,
            'validation_rules' => $rules,
            'has_rules' => !is_null($rules)
        ]);
    }
}