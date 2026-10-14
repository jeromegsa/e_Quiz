import api from '../api'
import type { APIResponse } from '../types'
import type { Quizz, InputCreateQuizz, InputUpdateQuizz } from './types'

async function getQuizzes() {
  try {
    return await api.get<APIResponse<Quizz[]>>('quizzes')
  } catch (error) {
    console.error('Error fetching quizzes:', error)
    throw error // Gestion de l'erreur ici
  }
}
async function fetchAllQuizz(): Promise<Quizz[]> {
  try {
    const response = await api.get<APIResponse<Quizz[]>>('quizzes')

    // Vérifie si la réponse contient des données
    if (response.data && response.data.success) {
      return response.data.data // Retourne directement le tableau de quizzes
    } else {
      throw new Error('Aucun quiz trouvé ou erreur dans la réponse')
    }
  } catch (error) {
    console.error('Error fetching quizzes:', error)
    throw error // Gestion de l'erreur ici
  }
}

async function getQuizz(id: number) {
  try {
    return await api.get<APIResponse<Quizz>>(`quizzes/${id}`)
  } catch (error) {
    console.error(`Error fetching quiz with id ${id}:`, error)
    throw error
  }
}

async function createQuizz(input: InputCreateQuizz|FormData) {
  try {
    return await api.post<APIResponse<Quizz>>('quizzes', input)
  } catch (error) {
    console.error('Error creating quiz:', error)
    throw error
  }
}
async function updateQuizz(input: InputUpdateQuizz) {
  try {
    const payload = { is_active: input.is_active }
    return await api.put<APIResponse<Quizz>>(`quizzes/${input.id}`, payload)
  } catch (error: any) {
    if (error.response) {
      console.error('API Error:', error.response.data)
    }
    throw error
  }
}

async function deleteQuizz(id: number) {
  try {
    return await api.delete<APIResponse<boolean>>(`quizzes/${id}`)
  } catch (error) {
    console.error(`Error deleting quiz with id ${id}:`, error)
    throw error
  }
}

export default {
  getQuizzes,
  getQuizz,
  createQuizz,
  updateQuizz,
  deleteQuizz,

  fetchAllQuizz,
}
