import api from '../api'
import type { APIResponse } from '../types'
import type { Question, InputCreateQuestion, InputUpdateQuestion } from './types'

// Récupérer toutes les questions
async function getQuestions() {
  try {
    return await api.get<APIResponse<Question[]>>('questions')
  } catch (error) {
    console.error('Error fetching questions', error)
    throw error
  }
}

// Récupérer une question spécifique par son ID
async function getQuestion(id: number) {
  try {
    return await api.get<APIResponse<Question>>(`questions/${id}`)
  } catch (error) {
    console.error(`Error fetching question with id ${id}:`, error)
    throw error
  }
}

// Créer une nouvelle question
async function createQuestion(input: InputCreateQuestion | FormData) {
  try {
    return await api.post<APIResponse<Question>>('questions', input)
  } catch (error) {
    console.error('Error creating question:', error)
    throw error
  }
}

// Mettre à jour une question
async function updateQuestion(input: InputUpdateQuestion) {
  try {
    return await api.put<APIResponse<Question>>(`questions/${input.id}`, input)
  } catch (error) {
    console.error(`Error updating question with id ${input.id}:`, error)
    throw error
  }
}

// Supprimer une question
async function deleteQuestion(id: number) {
  try {
    return await api.delete<APIResponse<boolean>>(`questions/${id}`)
  } catch (error) {
    console.error(`Error deleting question with id ${id}:`, error)
    throw error
  }
}

export default {
  getQuestions,
  getQuestion,
  createQuestion,
  updateQuestion,
  deleteQuestion,
}
