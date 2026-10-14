import { defineStore } from 'pinia'
import { ref } from 'vue'
import type {
  InputCreateQuestion,
  InputUpdateQuestion,
  Question,
} from '../../services/questions/types'
import type { APIResponse } from '../../services/types'
import { API } from '../../services'
import { AxiosError } from 'axios'

const isLoading = ref(false)
const errorMessage = ref('')

function handleApiError(error: unknown): APIResponse<null> {
  const _error = error as AxiosError<string>
  return { success: false, status: _error.response?.status, data: null }
}

export const useQuestionStore = defineStore('questionStore', () => {
  const questions = ref<Question[]>([])

  function initQuestions(data: Question[]) {
    questions.value = data
  }

  function addNewQuestion(question: Question) {
    questions.value.push(question)
  }

  function removeQuestion(id: number) {
    const idx = questions.value.findIndex((s) => s.id === id)
    if (idx !== -1) {
      questions.value.splice(idx, 1)
    }
  }

  function updateQuestionInStore(updatedQuestion: Question) {
    const index = questions.value.findIndex((q) => q.id === updatedQuestion.id)
    if (index !== -1) {
      questions.value[index] = updatedQuestion
    }
  }

  async function dispatchGetQuestions(): Promise<APIResponse<null>> {
    isLoading.value = true
    errorMessage.value = ''
    try {
      const response = await API.question.getQuestions()
      if (response && response.status === 200 && response.data.data) {
        initQuestions(response.data.data)
        return { success: true, data: null }
      }
    } catch (error) {
      errorMessage.value = 'Erreur lors du chargement des questions'
      return handleApiError(error)
    } finally {
      isLoading.value = false
    }
    return { success: false, data: null, status: 400 }
  }

  async function dispatchCreateQuestion(
    input: InputCreateQuestion | FormData
  ): Promise<APIResponse<null>> {
    try {
      const response = await API.question.createQuestion(input)
      if (response && response.status === 200 && response.data.data) {
        addNewQuestion(response.data.data)
        return { success: true, data: null }
      }
    } catch (error) {
      return handleApiError(error)
    }
    return { success: false, data: null, status: 400 }
  }

  async function dispatchDeleteQuestion(id: number): Promise<APIResponse<null>> {
    try {
      const response = await API.question.deleteQuestion(id)
      if (response && response.status === 200) {
        removeQuestion(id)
        return { success: true, data: null }
      }
    } catch (error) {
      return handleApiError(error)
    }
    return { success: false, data: null, status: 400 }
  }

  async function dispatchUpdateQuestion(input: InputUpdateQuestion): Promise<APIResponse<null>> {
    try {
      const response = await API.question.updateQuestion(input)
      if (response && response.status === 200 && response.data.data) {
        updateQuestionInStore(response.data.data)
        return { success: true, data: null }
      }
    } catch (error) {
      return handleApiError(error)
    }
    return { success: false, data: null, status: 400 }
  }

  return {
    questions,
    initQuestions,
    addNewQuestion,
    removeQuestion,
    dispatchGetQuestions,
    dispatchCreateQuestion,
    dispatchDeleteQuestion,
    dispatchUpdateQuestion,
  }
})
