import { defineStore } from 'pinia'
import { ref } from 'vue'
import authAPI, { isAdmin, login, logout } from '../../services/auth/index'
import type { InputCreateUser, InputLoginUser, User } from '../../services/auth/types'
import { AxiosError } from 'axios'

export const useAuthStore = defineStore('authStore', () => {
  // État des données utilisateur
  const user = ref<User>()
  const error = ref<string | null>(null)

  // Initialiser les données de l'utilisateur
  function initUser(data: User) {
    user.value = data
  }

  // Fonction pour l'inscription
  async function dispatchCreateUser(
    input: InputCreateUser
  ): Promise<{ success: boolean; message?: string }> {
    try {
      console.log('Donnée : ', input)
      const response = await authAPI.createUser(input) // Appelle la fonction d'inscription
      const data = response.data //accéder au données de la reponse
      console.log(' response  : ', response)
      if (response.status === 201) {
        initUser(data.content) // Initialiser l'utilisateur si l'inscription réussit
        return {
          success: true,
        }
      }
      return {
        success: false,
        message: 'Inscription échouée',
      }
    } catch (error: any) {
      const _error = error as AxiosError<string>
      error.value = _error.response?.data || 'Une erreur est survenue'
      return {
        success: false,
        message: error.value,
      }
    }
  }

  //Fonction pour le login
  async function dispatchLogin(
    input: InputLoginUser
  ): Promise<{ success: boolean; message?: string; user?: User | null }> {
    try {
      const data = await login(input) // Appelle la fonction de login
      console.log('Donnée : ', input)
      console.log(' response  : ', data)
   

      if (data.access_token) {
        initUser(data.user) // Initialiser l'utilisateur si la connexion réussit
        return {
          success: true,
          user: data.user,
        }
      }
      return {
        success: false,
        message: 'Connexion échouée',
      }
    } catch (error: any) {
      const _error = error as AxiosError<string>
      error.value = _error.response?.data || 'Une erreur est survenue'
      return {
        success: false,
        message: error.value,
      }
    }
  }
  //Fonction pour le logout

  async function dispatchLogout() {
    try {
      await logout() // Appelle la fonction de déconnexion
      user.value = undefined // Réinitialiser l'utilisateur
      return { success: true }
    } catch (error: any) {
      error.value = 'Une erreur est survenue lors de la déconnexion.'
      return { success: false, message: error.value }
    }
  }

  return {
    user,
    error,
    dispatchCreateUser,
    dispatchLogin,
    dispatchLogout,
    initUser,
  }
})
