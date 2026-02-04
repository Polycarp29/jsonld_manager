<template>
  <AppLayout title="Automated Schema Builder">
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
              AI-Augmented Generator
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-white tracking-tight mb-6">
              9UBET <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Auto-Schema</span>
            </h1>
            <p class="text-slate-400 font-medium text-lg max-w-xl leading-relaxed">
              Launch enterprise-grade structured data for Organization and WebSite contexts in seconds. 
              Our smart builder encapsulates the 9UBET SEO DNA.
            </p>
          </div>
          <Link 
            href="/schemas" 
            class="group flex items-center gap-4 bg-white/5 hover:bg-white/10 text-white px-8 py-5 rounded-3xl font-bold transition-standard border border-white/10 backdrop-blur-xl"
          >
            <svg class="w-6 h-6 text-slate-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Cancel & Return
          </Link>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
        <!-- Progress Sidebar -->
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

        <!-- content canvas -->
        <div class="lg:col-span-2">
          <form @submit.prevent="submit" class="bg-white rounded-[3.5rem] shadow-premium border border-slate-100 overflow-hidden">
            <!-- Step 1: Base Configuration -->
            <div v-show="currentStep === 0" class="p-10 md:p-16 space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-500">
              <div class="grid grid-cols-1 gap-10">
                <div class="space-y-4">
                  <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Internal Recognition Name</label>
                  <input
                    v-model="form.name"
                    type="text"
                    placeholder="e.g., Home Page Landing (Multi-Type)"
                    class="block w-full px-8 py-5 rounded-3xl border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-standard text-slate-900 font-bold text-lg placeholder:text-slate-300"
                  />
                  <p v-if="form.errors.name" class="text-red-500 text-xs font-bold ml-2">{{ form.errors.name }}</p>
                </div>

                <div class="space-y-4">
                  <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Contextual Meta Description</label>
                  <textarea
                    v-model="form.meta_description"
                    rows="4"
                    placeholder="Kenya's leading betting platform with fastest M-Pesa withdrawals..."
                    class="block w-full px-8 py-5 rounded-3xl border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-standard text-slate-900 font-medium placeholder:text-slate-300"
                  ></textarea>
                  <p v-if="form.errors.meta_description" class="text-red-500 text-xs font-bold ml-2">{{ form.errors.meta_description }}</p>
                </div>

                <div class="space-y-4">
                  <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Canonical Link Destination</label>
                  <input
                    v-model="form.page_link"
                    type="url"
                    placeholder="https://www.9ubet.co.ke"
                    class="block w-full px-8 py-5 rounded-3xl border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-standard text-slate-900 font-medium placeholder:text-slate-300"
                  />
                  <p v-if="form.errors.page_link" class="text-red-500 text-xs font-bold ml-2">{{ form.errors.page_link }}</p>
                </div>
              </div>
            </div>

            <!-- Step 2: Content Selection -->
            <div v-show="currentStep === 1" class="p-10 md:p-16 space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-500">
               <div class="text-center space-y-4 mb-8">
                  <h3 class="text-3xl font-black text-slate-900 tracking-tight">What defines this page?</h3>
                  <p class="text-slate-500 font-medium">Toggle the schemas you wish to inject into this template.</p>
               </div>
               
               <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                  <button 
                    type="button"
                    @click="form.includes_products = !form.includes_products"
                    :class="form.includes_products ? 'bg-blue-600 border-blue-600 shadow-xl shadow-blue-100 ring-4 ring-blue-50' : 'bg-white border-slate-200 hover:bg-slate-50'"
                    class="relative group p-10 rounded-[2.5rem] border-2 text-left transition-standard"
                  >
                    <div :class="form.includes_products ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-600'" class="w-16 h-16 rounded-3xl flex items-center justify-center mb-8 transition-standard">
                      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                      </svg>
                    </div>
                    <h4 :class="form.includes_products ? 'text-white' : 'text-slate-900'" class="text-2xl font-black mb-2">Products</h4>
                    <p :class="form.includes_products ? 'text-blue-100/70' : 'text-slate-500'" class="text-sm font-medium">Dynamic catalog for sports, casino, or individual games.</p>
                    <div v-if="form.includes_products" class="absolute top-6 right-6 text-white font-black text-xs uppercase tracking-widest bg-white/20 px-4 py-2 rounded-full backdrop-blur-md">Active</div>
                  </button>

                  <button 
                    type="button"
                    @click="form.includes_services = !form.includes_services"
                    :class="form.includes_services ? 'bg-emerald-600 border-emerald-600 shadow-xl shadow-emerald-100 ring-4 ring-emerald-50' : 'bg-white border-slate-200 hover:bg-slate-50'"
                    class="relative group p-10 rounded-[2.5rem] border-2 text-left transition-standard"
                  >
                    <div :class="form.includes_services ? 'bg-white/20 text-white' : 'bg-emerald-50 text-emerald-600'" class="w-16 h-16 rounded-3xl flex items-center justify-center mb-8 transition-standard">
                      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                      </svg>
                    </div>
                    <h4 :class="form.includes_services ? 'text-white' : 'text-slate-900'" class="text-2xl font-black mb-2">Services</h4>
                    <p :class="form.includes_services ? 'text-emerald-100/70' : 'text-slate-500'" class="text-sm font-medium">Financial utilities like M-Pesa deposits and withdrawals.</p>
                    <div v-if="form.includes_services" class="absolute top-6 right-6 text-white font-black text-xs uppercase tracking-widest bg-white/20 px-4 py-2 rounded-full backdrop-blur-md">Active</div>
                  </button>
               </div>
            </div>

            <!-- Step 3: Dynamic Catalog -->
            <div v-show="currentStep === 2" class="p-10 md:p-16 space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-500">
               <div v-if="form.includes_products" class="space-y-8">
                  <div class="flex justify-between items-end border-b border-slate-100 pb-8">
                    <div>
                      <h3 class="text-2xl font-black text-slate-900 tracking-tight">Product Catalog</h3>
                      <p class="text-slate-500 text-sm font-medium">Add all games or products offered on this page.</p>
                    </div>
                    <button 
                      @click.prevent="addProduct"
                      class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl font-bold transition-standard active:scale-95 text-xs uppercase tracking-widest"
                    >
                      Add Product
                    </button>
                  </div>

                  <div class="space-y-6">
                    <div v-for="(product, idx) in form.products" :key="idx" class="relative bg-slate-50 rounded-[2rem] p-8 border border-slate-100 overflow-hidden">
                      <button @click.prevent="removeProduct(idx)" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </button>
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                           <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Name</label>
                           <input v-model="product.name" type="text" placeholder="Sports Betting" class="w-full bg-white border-slate-200 rounded-2xl px-5 py-3 font-bold text-sm" />
                        </div>
                        <div class="space-y-2">
                           <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Context URL</label>
                           <input v-model="product.url" type="url" placeholder="https://..." class="w-full bg-white border-slate-200 rounded-2xl px-5 py-3 font-bold text-sm" />
                        </div>
                        <div class="md:col-span-2 space-y-2">
                           <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Description</label>
                           <textarea v-model="product.description" rows="2" placeholder="Best odds on Kenyan sports..." class="w-full bg-white border-slate-200 rounded-2xl px-5 py-3 font-medium text-sm"></textarea>
                        </div>
                      </div>
                    </div>
                    <div v-if="form.products.length === 0" class="text-center py-12 bg-slate-50/50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold italic">No products added yet.</p>
                    </div>
                  </div>
               </div>

               <div v-if="form.includes_services" class="space-y-8 pt-10 border-t border-slate-100">
                  <div class="flex justify-between items-end border-b border-slate-100 pb-8">
                    <div>
                      <h3 class="text-2xl font-black text-slate-900 tracking-tight">Financial Services</h3>
                      <p class="text-slate-500 text-sm font-medium">Define transaction or support utilities.</p>
                    </div>
                    <button 
                      @click.prevent="addService"
                      class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-2xl font-bold transition-standard active:scale-95 text-xs uppercase tracking-widest"
                    >
                      Add Service
                    </button>
                  </div>

                  <div class="space-y-6">
                    <div v-for="(service, idx) in form.services" :key="idx" class="relative bg-slate-50 rounded-[2rem] p-8 border border-slate-100">
                      <button @click.prevent="removeService(idx)" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </button>
                      <div class="grid grid-cols-1 gap-8">
                        <div class="space-y-2">
                           <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Service Name</label>
                           <input v-model="service.name" type="text" placeholder="M-Pesa Withdrawals" class="w-full bg-white border-slate-200 rounded-2xl px-5 py-3 font-bold text-sm" />
                        </div>
                        <div class="space-y-2">
                           <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Detail</label>
                           <textarea v-model="service.description" rows="2" placeholder="Processed within seconds..." class="w-full bg-white border-slate-200 rounded-2xl px-5 py-3 font-medium text-sm"></textarea>
                        </div>
                      </div>
                    </div>
                    <div v-if="form.services.length === 0" class="text-center py-12 bg-slate-50/50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold italic">No services added yet.</p>
                    </div>
                  </div>
               </div>
            </div>

            <!-- Wizard Footer Navigation -->
            <div class="px-10 py-10 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center">
              <button
                type="button"
                @click="prevStep"
                v-if="currentStep > 0"
                class="px-10 py-5 rounded-3xl text-sm font-black text-slate-600 hover:bg-slate-200 transition-standard active:scale-95 uppercase tracking-widest"
              >
                Previous Step
              </button>
              <div v-else></div>

              <div class="flex gap-4">
                <button
                  v-if="currentStep < 2"
                  type="button"
                  @click="nextStep"
                  class="bg-slate-900 border border-slate-800 text-white px-12 py-5 rounded-3xl font-black transition-standard shadow-2xl shadow-slate-200 active:scale-95 uppercase tracking-widest text-sm"
                >
                  Continue
                </button>
                <button
                  v-else
                  type="submit"
                  :disabled="form.processing"
                  class="bg-blue-600 hover:bg-blue-500 text-white px-16 py-5 rounded-3xl font-black transition-standard shadow-2xl shadow-blue-200 active:scale-95 disabled:opacity-50 flex items-center gap-4 uppercase tracking-widest text-sm"
                >
                  <span v-if="form.processing" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                  {{ form.processing ? 'Compiling JSON...' : 'Generate 9UBET Schema' }}
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
  { label: 'Foundation', title: 'SEO Basics' },
  { label: 'Intelligence', title: 'Content Types' },
  { label: 'Inventory', title: 'Catalog Detail' }
]

const form = useForm({
  name: '',
  meta_description: '',
  page_link: 'https://www.9ubet.co.ke',
  includes_products: true,
  includes_services: true,
  products: [
    { name: 'Sports Betting', description: 'Enjoy best odds on football, basketball, rugby and Kenyan sports events', url: 'https://www.9ubet.co.ke/sports' },
    { name: 'Live Casino', description: 'Real-time casino games with live dealers', url: 'https://www.9ubet.co.ke/casino' }
  ],
  services: [
    { name: 'M-Pesa Withdrawals', description: 'Fastest M-Pesa withdrawals in Kenya - processed within seconds' },
    { name: 'M-Pesa Deposits', description: 'Instant deposits via M-Pesa with zero fees - Tax free deposits' }
  ]
})

const addProduct = () => {
  form.products.push({ name: '', description: '', url: '' })
}

const removeProduct = (idx) => {
  form.products.splice(idx, 1)
}

const addService = () => {
  form.services.push({ name: '', description: '' })
}

const removeService = (idx) => {
  form.services.splice(idx, 1)
}

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

@keyframes fade-in {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slide-in-from-bottom-4 {
  from { transform: translateY(1rem); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

.animate-in {
  animation-fill-mode: both;
}
</style>
