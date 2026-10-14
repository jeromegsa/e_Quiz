import api from '../api'
import type { APIResponse } from '../types'
import type { User, InputCreateUser, InputUpdateUser, UserResponse, QuizzResult } from './types'

// Récupérer tous les utilisateurs
async function getUsers() {
  try {
    return await api.get<APIResponse<User[]>>('users')
  } catch (error) {
    console.error('Error fetching users', error)
    throw error
  }
}

// Récupérer un utilisateur spécifique par son ID
async function getUser(id: number) {
  try {
    return await api.get<APIResponse<User>>(`users/${id}`)
  } catch (error) {
    console.error(`Error fetching user with id ${id}:`, error)
    throw error
  }
}

// Créer un nouvel utilisateur
async function createUser(input: InputCreateUser) {
  try {
    return await api.post<APIResponse<User>>('users', input)
  } catch (error) {
    console.error('Error creating user:', error)
  }
}

// Mettre à jour un utilisateur
async function updateUser(input: InputUpdateUser) {
  try {
    return await api.put<APIResponse<User>>(`users/${input.id}`, input)
  } catch (error) {
    console.error(`Error updating user with id ${input.id}:`, error)
  }
}

// Supprimer un utilisateur
async function deleteUser(id: number) {
  try {
    return await api.delete<APIResponse<boolean>>(`users/${id}`)
  } catch (error) {
    console.error(`Error deleting user with id ${id}:`, error)
    throw error
  }
}

// Récupérer les détails d'un utilisateur avec ses quiz et réponses
async function getUserDetails(id: number) {
  try {
    return await api.get<
      APIResponse<{ user: User; quizzes: QuizzResult[]; responses: UserResponse[] }>
    >(`users/${id}/details`)
  } catch (error) {
    console.error(`Error fetching details of user with id ${id}:`, error)
  }
}

export default {
  getUsers,
  getUser,
  createUser,
  updateUser,
  deleteUser,
  getUserDetails,
}
