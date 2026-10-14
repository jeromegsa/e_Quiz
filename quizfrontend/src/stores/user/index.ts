import api from '@/services/api'
import type { APIResponse } from '@/services/types'
import type { User, InputCreateUser, InputUpdateUser, InputLogin } from '@/services/users/types'
import { API } from '@/services'
import { AxiosError } from 'axios'
import { ref } from 'vue'
import { defineStore } from 'pinia'

/**
 * Define a Pinia store for managing users.
 */
export const useUsertore = defineStore('userStore', () => {
  // State: an array to hold users
  const users = ref<User[]>([])

  /**
   * Initialize the user state with an array of users.
   * @param data - The array of users to set.
   */
  function initUser(data: User[]) {
    users.value = data
    console.log(users.value)
  }

  /**
   * Add a new user to the state.
   * @param user - The user to add.
   */
  function addNewUser(user: User) {
    users.value.push(user)
  }

  /**
   * Remove a user from the state by its ID.
   * @param id - The ID of the user to remove.
   */
  function removeUser(id: number) {
    const idx = users.value.findIndex((s) => s.id === id)
    if (idx !== -1) {
      users.value.splice(idx, 1) // Remove the user if found
    }
  }

  /**
   * Fetch all users from the API and update the state.
   * @returns A promise that resolves to an API response.
   */
  async function dispatchGetUsers(): Promise<APIResponse<null>> {
    try {
      const { status, data } = await API.user.getUsers()
      if (status === 200 && data.data) {
        // Extraire correctement les users
        initUser(data.data) // Initialize users with fetched data
        return { success: true, content: null }
      }
    } catch (error) {
      const _error = error as AxiosError<string>
      return { success: false, status: _error.response?.status, content: null }
    }
    return { success: false, content: null, status: 400 } // Fallback response
  }

  /**
   * Create a new user via the API and update the state.
   * @param input - The input data for the new user.
   * @returns A promise that resolves to an API response.
   */
  async function dispatchCreateUser(input: InputCreateUser): Promise<APIResponse<null>> {
    try {
      // Assure-toi que la réponse est bien typée et non null
      const response = await API.user.createUser(input)

      // Vérifie si la réponse existe avant de la déstructurer
      if (response && response.status === 200 && response.data.data) {
        addNewUser(response.data.data) // Ajouter l'utilisateur dans l'état
        return { success: true, content: null }
      }
    } catch (error) {
      const _error = error as AxiosError<string>
      return { success: false, status: _error.response?.status, content: null }
    }

    // En cas d'échec
    return { success: false, content: null, status: 400 }
  }

  /**
   * Delete a user by its ID via the API and update the state.
   * @param id - The ID of the user to delete.
   * @returns A promise that resolves to an API response.
   */
  async function dispatchDeleteUser(id: number): Promise<APIResponse<null>> {
    try {
      const { status } = await API.user.deleteUser(id)
      if (status === 200) {
        removeUser(id) // Remove the user from state after successful deletion
        return { success: true, content: null }
      }
    } catch (error) {
      const _error = error as AxiosError<string>
      return { success: false, status: _error.response?.status, content: null }
    }
    return { success: false, content: null, status: 400 } // Fallback response
  }

  /**
   * Update an existing user via the API.
   * @param input - The input data for the user to update.
   * @returns A promise that resolves to an API response.
   */
  async function dispatchUpdateUser(input: InputUpdateUser): Promise<APIResponse<null>> {
    try {
      // Appel à l'API sans déstructurer immédiatement
      const response = await API.user.updateUser(input)

      // Vérifie que la réponse est définie et déstructurer ensuite
      if (response && response.status === 200) {
        return { success: true, content: null }
      }
    } catch (error) {
      const _error = error as AxiosError<string>
      // Gestion des erreurs d'Axios avec vérification de l'erreur et du statut
      return { success: false, status: _error.response?.status, content: null }
    }

    // Retour par défaut en cas d'échec ou d'une réponse non valide
    return { success: false, content: null, status: 400 }
  }

  // Expose store methods and state
  return {
    users,
    initUser,
    removeUser,
    dispatchGetUsers,
    dispatchCreateUser,
    dispatchDeleteUser,
    dispatchUpdateUser,
  }
})
