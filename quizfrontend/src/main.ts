import { createPinia } from 'pinia'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/main.css'

// primevue
import 'primeicons/primeicons.css'
import PrimeVue from 'primevue/config'
import Aura from '@primevue/themes/aura'
import Button from 'primevue/button'
import ToastService from 'primevue/toastservice'
import Toast from 'primevue/toast' // Import du composant Toast
import ConfirmDialog from 'primevue/confirmdialog';
const app = createApp(App)
app.use(createPinia())
app.use(PrimeVue, {
  theme: {
    preset: Aura,
  },
})
app.component('app-button', Button)
app.component('Toast', Toast) // Enregistrer le composant Toast
app.use(ToastService)
app.use(router)
app.mount('#app')
app.component('ConfirmDialog', ConfirmDialog);