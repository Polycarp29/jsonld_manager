<template>
  <AppLayout title="Modular Schema Builder">
    <div class="max-w-5xl mx-auto space-y-12 pb-24">
      <!-- Mega Header -->
      <div class="relative overflow-hidden rounded-[3rem] bg-slate-900 p-12 md:p-20 shadow-2xl">
        <div class="absolute top-0 right-0 -m-20 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -m-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-10">
          <div class="text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 text-blue-300 text-[10px] font-black uppercase tracking-[0.2em] mb-6 border border-blue-500/30">
              <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
              </span>
              Modular Intelligence
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-white tracking-tight mb-6">
              9UBET <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Flex-Builder</span>
            </h1>
            <p class="text-slate-400 font-medium text-lg max-w-xl leading-relaxed">
              Create highly adaptive structured data. Toggle brand identity, add custom categories, and tailor every page context.
            </p>
          </div>
          <Link 
            href="/schemas" 
            class="group flex items-center gap-4 bg-white/5 hover:bg-white/10 text-white px-8 py-5 rounded-3xl font-bold transition-standard border border-white/10 backdrop-blur-xl"
          >
            <svg class="w-6 h-6 text-slate-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Cancel
          </Link>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
        <!-- Progress -->
        <div class="lg:sticky lg:top-24 space-y-4">
          <div 
            v-for="(step, idx) in steps" 
            :key="idx"
            class="group relative flex items-center gap-6 p-6 rounded-[2rem] transition-standard border shadow-sm"
            :class="[
              currentStep === idx ? 'bg-white border-blue-200 shadow-blue-100 ring-1 ring-blue-50' : 'bg-slate-50 border-transparent opacity-60 grayscale'
            ]"
          >
            <div 
              class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-lg transition-standard"
              :class="[
                currentStep === idx ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 scale-110' : 'bg-slate-200 text-slate-500'
              ]"
            >
              {{ idx + 1 }}
            </div>
            <div>
              <h4 class="font-bold text-slate-900 leading-tight uppercase tracking-widest text-[10px]">{{ step.label }}</h4>
              <p class="text-slate-500 text-xs font-medium">{{ step.title }}</p>
            </div>
          </div>
        </div>

        <!-- Canvas -->
        <div class="lg:col-span-2">
          <form @submit.prevent="submit" class="bg-white rounded-[3.5rem] shadow-premium border border-slate-100 overflow-hidden">
            <!-- Step 1: Base -->
            <div v-show="currentStep === 0" class="p-10 md:p-16 space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-500">
              <div class="grid grid-cols-1 gap-10">
                <div class="space-y-4">
                  <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Internal Recognition Name</label>
                  <input v-model="form.name" type="text" placeholder="e.g., Dynamic Subpage Markup" class="block w-full px-8 py-5 rounded-3xl border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-standard text-slate-900 font-bold text-lg placeholder:text-slate-300" />
                </div>
                <div class="space-y-4">
                  <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Contextual Meta Description</label>
                  <textarea v-model="form.meta_description" rows="4" placeholder="Description for this specific page..." class="block w-full px-8 py-5 rounded-3xl border-slate-200 bg-slate-50/50 focus:bg-white transition-standard text-slate-900 font-medium"></textarea>
                </div>
                <div class="space-y-4">
                  <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Canonical Link Destination</label>
                  <input v-model="form.page_link" type="url" class="block w-full px-8 py-5 rounded-3xl border-slate-200 bg-slate-50/50 focus:bg-white transition-standard text-slate-900 font-medium" />
                </div>
              </div>
            </div>

            <!-- Step 2: Module Configuration -->
            <div v-show="currentStep === 1" class="p-10 md:p-16 space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-500">
               <div class="text-center space-y-4 mb-8">
                  <h3 class="text-3xl font-black text-slate-900 tracking-tight">Construct Your Page</h3>
                  <p class="text-slate-500 font-medium">Toggle core identity or add specific category schemas.</p>
               </div>
               
               <div class="space-y-6">
                  <!-- Core Module Toggle -->
                  <div 
                    @click="form.include_brand_identity = !form.include_brand_identity"
                    :class="form.include_brand_identity ? 'bg-slate-900 border-slate-900 shadow-xl' : 'bg-white border-slate-200'"
                    class="group p-8 rounded-[2.5rem] border-2 cursor-pointer transition-standard flex justify-between items-center"
                  >
                    <div class="flex items-center gap-6">
                      <div :class="form.include_brand_identity ? 'bg-blue-500' : 'bg-slate-100 text-slate-400'" class="w-14 h-14 rounded-2xl flex items-center justify-center text-white transition-standard">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                      </div>
                      <div>
                        <h4 :class="form.include_brand_identity ? 'text-white' : 'text-slate-900'" class="text-xl font-black">Brand Identity</h4>
                        <p :class="form.include_brand_identity ? 'text-slate-400' : 'text-slate-500'" class="text-xs font-medium">Injects Organization & WebSite JSON-LD.</p>
                      </div>
                    </div>
                    <div :class="form.include_brand_identity ? 'bg-blue-500 text-white' : 'bg-slate-100 text-slate-400'" class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest">
                      {{ form.include_brand_identity ? 'Active' : 'Disabled' }}
                    </div>
                  </div>

                  <!-- Dynamic Schema Modules -->
                  <div class="space-y-4">
                    <div class="flex justify-between items-center px-4">
                      <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Additional Schema Modules</label>
                      <button @click.prevent="addModule" class="text-blue-600 font-bold text-xs uppercase tracking-widest hover:blue-700">+ Add Module</button>
                    </div>

                    <TransitionGroup 
                      enter-active-class="transition duration-300 ease-out" 
                      enter-from-class="opacity-0 translate-y-4" 
                      enter-to-class="opacity-100 translate-y-0"
                      leave-active-class="transition duration-200 ease-in"
                      leave-from-class="opacity-100 translate-y-0"
                      leave-to-class="opacity-0 translate-y-4"
                    >
                      <div v-for="(module, idx) in form.modules" :key="idx" class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100 flex items-center justify-between gap-6">
                        <div class="flex-grow">
                          <select v-model="module.schema_type_id" class="w-full bg-white border-slate-200 rounded-2xl px-5 py-3 font-bold text-sm h-14 appearance-none">
                            <option value="">Select Schema Category...</option>
                            <option v-for="type in schemaTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                          </select>
                        </div>
                        <button @click.prevent="removeModule(idx)" class="w-14 h-14 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-300 hover:text-red-500 transition-colors shadow-sm">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </div>
                    </TransitionGroup>
                    
                    <div v-if="form.modules.length === 0" class="text-center py-10 bg-slate-50/50 rounded-[2rem] border-2 border-dashed border-slate-200">
                      <p class="text-slate-400 text-xs font-bold italic">No custom modules added.</p>
                    </div>
                  </div>
               </div>
            </div>

            <!-- Step 3: Module Data -->
            <div v-show="currentStep === 2" class="p-10 md:p-16 space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-500">
               <!-- Brand Identity Data (If on) -->
               <div v-if="form.include_brand_identity" class="space-y-10">
                  <div class="flex justify-between items-end border-b border-slate-100 pb-6">
                    <div>
                      <h3 class="text-2xl font-black text-slate-900 tracking-tight">Identity Details</h3>
                      <p class="text-slate-500 text-sm font-medium">Standard 9UBET Organization/WebSite data.</p>
                    </div>
                  </div>
                  <div class="bg-blue-50/50 p-8 rounded-[2.5rem] border border-blue-100">
                    <p class="text-blue-800 font-medium text-sm">
                      Brand identity will include the standard 9UBET Logo, Social links, M-Pesa payment info, and Aggregate Ratings.
                    </p>
                  </div>
               </div>

               <!-- Dynamic Modules Data -->
               <div v-for="(module, mIdx) in form.modules" :key="mIdx" class="space-y-8 p-10 bg-slate-50 rounded-[3rem] border border-slate-100 relative">
                  <div class="absolute top-8 right-8 px-4 py-1.5 bg-blue-600 text-white rounded-full text-[9px] font-black uppercase tracking-widest">
                    {{ getTypeName(module.schema_type_id) }} Module
                  </div>
                  
                  <div class="space-y-6">
                    <h3 class="text-xl font-black text-slate-900">Configure Module #{{ mIdx + 1 }}</h3>
                    
                    <div v-if="getTypeKey(module.schema_type_id) === 'product'" class="space-y-6">
                      <div class="flex justify-between items-center">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Add Catalog Items</label>
                        <button @click.prevent="addProduct(mIdx)" class="text-blue-600 font-bold text-xs">+ Add Product</button>
                      </div>
                      <div v-for="(p, pIdx) in module.data.items" :key="pIdx" class="bg-white p-6 rounded-2xl border border-slate-100 space-y-4">
                        <input v-model="p.name" placeholder="Product Name" class="w-full border-slate-200 rounded-xl px-4 py-2 text-sm font-bold" />
                        <textarea v-model="p.description" placeholder="Description..." class="w-full border-slate-200 rounded-xl px-4 py-2 text-sm"></textarea>
                        <input v-model="p.url" placeholder="URL" class="w-full border-slate-200 rounded-xl px-4 py-2 text-sm" />
                        <button @click.prevent="removeProduct(mIdx, pIdx)" class="text-red-400 text-[10px] font-bold uppercase tracking-widest">Remove item</button>
                      </div>
                    </div>

                    <div v-else-if="getTypeKey(module.schema_type_id) === 'service' || getTypeKey(module.schema_type_id) === 'financial_product'" class="space-y-6">
                      <div class="flex justify-between items-center">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Add Service Items</label>
                        <button @click.prevent="addService(mIdx)" class="text-blue-600 font-bold text-xs">+ Add Service</button>
                      </div>
                      <div v-for="(s, sIdx) in module.data.items" :key="sIdx" class="bg-white p-6 rounded-2xl border border-slate-100 space-y-4">
                        <input v-model="s.name" placeholder="Service Name" class="w-full border-slate-200 rounded-xl px-4 py-2 text-sm font-bold" />
                        <textarea v-model="s.description" placeholder="Detail..." class="w-full border-slate-200 rounded-xl px-4 py-2 text-sm"></textarea>
                        <button @click.prevent="removeService(mIdx, sIdx)" class="text-red-400 text-[10px] font-bold uppercase tracking-widest">Remove item</button>
                      </div>
                    </div>

                    <div v-else class="text-center py-10 bg-white rounded-2xl border border-slate-200">
                      <p class="text-slate-400 font-bold text-sm italic">Generic logic for {{ getTypeName(module.schema_type_id) }} is under development. Fields can be managed in the full editor after generation.</p>
                    </div>
                  </div>
               </div>

               <div v-if="!form.include_brand_identity && form.modules.length === 0" class="text-center py-32 bg-slate-50/50 rounded-[3rem] border-2 border-dashed border-slate-200">
                  <p class="text-slate-400 font-black text-xl italic mb-4">Empty Schema Architecture</p>
                  <p class="text-slate-500 font-medium">Please enable Brand Identity or add at least one module in Step 2.</p>
               </div>
            </div>

            <!-- Wizard Nav -->
            <div class="px-10 py-10 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center">
              <button type="button" @click="prevStep" v-if="currentStep > 0" class="px-10 py-5 rounded-3xl text-sm font-black text-slate-600 hover:bg-slate-200 transition-standard uppercase tracking-widest">Previous</button>
              <div v-else></div>

              <div class="flex gap-4">
                <button v-if="currentStep < 2" type="button" @click="nextStep" class="bg-slate-900 text-white px-12 py-5 rounded-3xl font-black transition-standard shadow-2xl active:scale-95 uppercase tracking-widest text-sm">Continue</button>
                <button v-else type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-16 py-5 rounded-3xl font-black transition-standard shadow-2xl active:scale-95 disabled:opacity-50 uppercase tracking-widest text-sm">
                  {{ form.processing ? 'Syncing...' : 'Build Modular Schema' }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '../../Layouts/AppLayout.vue'

const props = defineProps({
  schemaTypes: Array
})

const currentStep = ref(0)
const steps = [
  { label: 'Foundation', title: 'SEO Context' },
  { label: 'Modular', title: 'Schema Blocks' },
  { label: 'Catalog', title: 'Data Entry' }
]

const form = useForm({
  name: '',
  meta_description: '',
  page_link: 'https://www.9ubet.co.ke',
  include_brand_identity: true,
  modules: []
})

const addModule = () => {
  form.modules.push({
    schema_type_id: '',
    data: { items: [] }
  })
}

const removeModule = (idx) => {
  form.modules.splice(idx, 1)
}

const addProduct = (mIdx) => {
  form.modules[mIdx].data.items.push({ name: '', description: '', url: '' })
}

const removeProduct = (mIdx, pIdx) => {
  form.modules[mIdx].data.items.splice(pIdx, 1)
}

const addService = (mIdx) => {
  form.modules[mIdx].data.items.push({ name: '', description: '' })
}

const removeService = (mIdx, sIdx) => {
  form.modules[mIdx].data.items.splice(sIdx, 1)
}

const getTypeName = (id) => props.schemaTypes.find(t => t.id === id)?.name || 'Custom'
const getTypeKey = (id) => props.schemaTypes.find(t => t.id === id)?.type_key || ''

const nextStep = () => {
  if (currentStep.value < 2) currentStep.value++
}

const prevStep = () => {
  if (currentStep.value > 0) currentStep.value--
}

const submit = () => {
  form.post('/schemas/automated')
}
</script>

<style scoped>
.transition-standard {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
@keyframes slide-in-from-bottom-4 { from { transform: translateY(1rem); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.animate-in { animation-fill-mode: both; }
</style>
