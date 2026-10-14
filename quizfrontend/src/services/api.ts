import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL, // URL de ton API Laravel
  // baseURL:  "https://jsonplaceholder.typicode.com/", // URL de ton API Laravel
  headers: {
    'Content-Type': 'multipart/form-data',
  },
})

export default api
