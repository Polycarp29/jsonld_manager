# Google Schema.org Validation Guide

This JSON-LD Manager includes comprehensive Google Schema.org validation to ensure your structured data passes Google's Rich Results Test and meets SEO requirements.

## Key Features

### 🔍 Real-time Validation
- **Schema.org compliance checking** - Validates against official Schema.org standards
- **Google-specific requirements** - Enforces Google's additional requirements for Rich Results
- **Required field enforcement** - Ensures critical fields like "offers", "review", or "aggregateRating" are present for Product schemas

### 🛠️ Validation System Components

#### 1. SchemaValidationService (`backend/app/Services/SchemaValidationService.php`)
Comprehensive validation service that checks:

**For Product/Service schemas:**
- ✅ Must include at least one of: `offers`, `review`, or `aggregateRating`
- ✅ Required fields: `name`
- ⚠️ Recommended fields: `image`, `description`, `brand`

**For offers:**
- ✅ Must include: `price`, `priceCurrency`, `availability`
- ✅ Validates availability values against Schema.org standards

**For FAQ schemas:**
- ✅ `mainEntity` array with proper Question/Answer structure
- ✅ Each question must have `acceptedAnswer` with Answer type

**For HowTo schemas:**
- ✅ `step` array with HowToStep objects
- ✅ Each step must have required `text` field

#### 2. Enhanced Schema Model (`backend/app/Models/Schema.php`)
- `validateSchema()` - Validates current schema against Google requirements
- `isValidForGoogle()` - Quick boolean check for Google compliance
- `getValidationMessages()` - Detailed error and warning messages
- `getRequiredFields()` - Gets validation rules for schema type

#### 3. Validation API Endpoints (`backend/routes/api.php`)
```
GET /api/v1/schemas/{id}/validate - Validate a schema
GET /api/v1/schemas/{id}/test-google - Get Google Rich Results Test instructions
GET /api/v1/schema-types/{id}/required-fields - Get required fields for schema type
```

#### 4. Frontend Validation Component (`frontend/src/components/SchemaValidator.vue`)
Interactive validation interface with:
- Real-time validation results
- Google Rich Results Test integration
- Required fields reference
- Copy-to-clipboard JSON-LD export

## Common Google Validation Errors & Solutions

### ❌ "Either 'offers', 'review', or 'aggregateRating' should be specified"
**Solution:** For Product/Service schemas, add at least one of these properties:

```json
{
  "@type": "Product",
  "name": "Sports Betting",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "KES",
    "availability": "https://schema.org/InStock"
  }
}
```

### ❌ "Missing required property 'name'"
**Solution:** Add a name field to your schema:

```json
{
  "@type": "Product",
  "name": "Your Product Name"
}
```

### ❌ "Invalid availability value"
**Solution:** Use valid Schema.org availability URLs:
- `https://schema.org/InStock`
- `https://schema.org/OutOfStock`
- `https://schema.org/PreOrder`
- `https://schema.org/BackOrder`
- `https://schema.org/Discontinued`
- `https://schema.org/LimitedAvailability`

### ❌ "FAQ mainEntity must have proper Question structure"
**Solution:** Structure FAQ properly:

```json
{
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How do I deposit?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "You can deposit using mobile money or bank transfer."
      }
    }
  ]
}
```

## Testing with Google Rich Results Test

### Automated Testing Flow:
1. **Validate Schema** - Click "Validate Schema" in the frontend
2. **Test with Google** - Click "Test with Google" to get test instructions
3. **Copy JSON-LD** - Copy the generated JSON-LD
4. **Open Google Tool** - Visit Google Rich Results Test
5. **Paste & Test** - Paste JSON-LD and run Google's validation

### Manual Testing:
1. Visit [Google Rich Results Test Tool](https://search.google.com/test/rich-results)
2. Select "Code Snippet" tab
3. Paste your JSON-LD (from export or validation response)
4. Click "TEST CODE"
5. Review Google's validation results

## Schema Types with Validation Rules

### Product/Service Schemas
- **Sports Betting Products**
- **Casino Games** 
- **Video Games (Aviator, etc.)**
- **Betting Services**

### Content Schemas
- **FAQ Pages** - Customer support questions
- **HowTo Guides** - Deposit/withdrawal instructions
- **Organization** - Company information
- **WebSite** - Homepage structured data

### Local Business
- **LocalBusiness** - Physical locations
- **ContactPoint** - Customer service info

## Field Type Validation

The system validates different field types:
- **URL fields** - Must be valid URLs
- **Date fields** - ISO 8601 format validation
- **Number fields** - Numeric validation
- **Boolean fields** - True/false validation
- **Array/Object fields** - Proper nesting validation

## API Usage Examples

### Validate a Schema
```javascript
const validation = await fetch('/api/v1/schemas/1/validate')
const result = await validation.json()

console.log(result.is_valid) // true/false
console.log(result.errors) // Array of error messages
console.log(result.warnings) // Array of warnings
```

### Test with Google
```javascript
const test = await fetch('/api/v1/schemas/1/test-google')
const result = await test.json()

console.log(result.json_ld) // Generated JSON-LD
console.log(result.test_url) // Google test tool URL
console.log(result.validation) // Validation results
```

### Get Required Fields
```javascript
const fields = await fetch('/api/v1/schema-types/1/required-fields')
const result = await fields.json()

console.log(result.validation_rules) // Required field rules
```

This validation system ensures your JSON-LD structured data meets both Schema.org standards and Google's specific requirements for Rich Results, helping improve your website's SEO performance and search result appearance.