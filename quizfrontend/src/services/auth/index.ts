// src/services/auth/index.ts
import http from '../api'
import type { APIResponse } from '../types'
import type { User, InputCreateUser, InputUpdateUser, InputLoginUser } from './types'

// Intercepteur pour ajouter le token à chaque requête
http.interceptors.request.use(
  (config) => {
    const token = getToken()
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Fonction pour se connecter et récupérer un token
export const login = async (input: InputLoginUser) => {
  try {
    const response = await http.post<User>('/login', input)

    if (response.data.access_token) {
      localStorage.setItem('user', JSON.stringify(response.data))
      isAdmin();
      console.log(isAdmin());


    }

    return response.data;
  } catch (error) {
    console.error('Error logging in:', error)
    throw error
  }
}

// Fonction pour récupérer le token stocké
export const getToken = () => {
  const storedData = localStorage.getItem('user');
  if (storedData) {
    const userData = JSON.parse(storedData);
    return userData.access_token; // Accéder directement au token
  }
  return null; // Retourner null si aucune donnée n'est trouvée
}

// Fonction pour vérifier si l'utilisateur est admin
export const isAdmin = () => {
  const user = JSON.parse(localStorage.getItem('user') || 'null');
  
  // Vérifier le rôle dans l'objet user
  const role = user?.user?.role; // Utilisez l'opérateur de coalescence pour accéder à user.role
 
   return role === 'admin'
}


// Fonction pour déconnecter l'utilisateur
export const logout = async () => {
  try {
    const token = getToken()

    if (token) {
      await http.post(
        '/logout',
        {},
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      )
    }

    localStorage.removeItem('user')
  } catch (error) {
    console.error('Error logging out:', error)
    throw error
  }
}

// Fonction pour récupérer tous les utilisateurs
async function getUsers() {
  return await http.get<APIResponse<User[]>>('users')
}

// Fonction pour supprimer un utilisateur
async function deleteUser(id: number) {
  return await http.delete<APIResponse<boolean>>(`users/${id}`) // Corrected from 'User' to 'users'
}

// Fonction pour créer un nouvel utilisateur
async function createUser(input: InputCreateUser) {
  return await http.post<APIResponse<User>>('users', input)
}

// Fonction pour mettre à jour un utilisateur
async function updateUser(input: InputUpdateUser) {
  return await http.put<APIResponse<boolean>>(`users/${input.id}`, input) // Corrected to include user ID
}

export default {
  getUsers,
  createUser,
  updateUser,
  deleteUser,
  login,
  logout,
  getToken,
  isAdmin, // Add isAdmin to the exported default object
}
