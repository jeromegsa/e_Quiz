import { defineStore } from 'pinia'
import { ref } from 'vue'
import type { InputCreateQuizz, InputUpdateQuizz, Quizz } from '../../services/quizzs/types'
import type { APIResponse } from '../../services/types'
import { API } from '../../services'
import { AxiosError } from 'axios'

function handleApiError(error: unknown): APIResponse<null> {
  const _error = error as AxiosError<string>
  return { success: false, status: _error.response?.status, data: null }
}

export const useQuizzStore = defineStore('quizzStore', () => {
  const quizzs = ref<Quizz[]>([])

  function initQuizzs(data: Quizz[]) {
    quizzs.value = data
    console.log(quizzs.value)
  }

  function addNewQuizz(quizz: Quizz) {
    quizzs.value.push(quizz)
  }

  function removeQuizz(id: number) {
    const idx = quizzs.value.findIndex((s) => s.id === id)
    if (idx !== -1) {
      quizzs.value.splice(idx, 1)
    }
  }

  function updateQuizzInStore(updatedQuizz: Quizz) {
    const index = quizzs.value.findIndex((q) => q.id === updatedQuizz.id)
    if (index !== -1) {
      quizzs.value[index] = updatedQuizz // Mise à jour du quiz dans l'état
    }
  }

  async function dispatchGetQuizzs(): Promise<APIResponse<null>> {
    try {
      const { status, data } = await API.quizz.getQuizzes()
      if (status === 200 && data.data) {
        initQuizzs(data.data)
        return { success: true, data: null }
      }
    } catch (error) {
      return handleApiError(error)
    }
    return { success: false, data: null, status: 400 }
  }

  async function dispatchCreateQuizz(input: InputCreateQuizz): Promise<APIResponse<null>> {
    try {
      // Initialise formData comme un nouvel objet FormData
      const formData = new FormData();
  
      // Ajout des champs principaux
      formData.append('title', input.title);
      formData.append('description', input.description);
      formData.append('is_active', input.is_active ? '1' : '0'); // Convertir en '1' ou '0'
      formData.append('duration', input.duration.toString());
  
      // Vérifie si l'image est un fichier avant de l'ajouter
      if (input.image_url instanceof File) {
        formData.append('quiz_image', input.image_url);
      }
  
      // Assurez-vous que les questions sont ajoutées comme un tableau
      input.questions.forEach((question, index) => {
        formData.append(`questions[${index}][libelle]`, question.libelle);
        formData.append(`questions[${index}][content]`, question.content);
        formData.append(`questions[${index}][question_type]`, question.question_type);
        formData.append(`questions[${index}][points]`, question.points.toString());
        formData.append(`questions[${index}][duration]`, question.duration.toString());
  
        // Si answer_options est présent, ajoutez-le également
        question.answer_options.forEach((option, optionIndex) => {
          formData.append(`questions[${index}][answer_options][${optionIndex}][content]`, option.content);
          formData.append(`questions[${index}][answer_options][${optionIndex}][is_correct]`, option.is_correct ? '1' : '0');
        });
      });
  
      // Effectue la requête API pour créer le quiz
      const { status, data } = await API.quizz.createQuizz(formData);
      if (status === 201 && data.data) {
        addNewQuizz(data.data);
        return { success: true, status: 201, data: null };
      }
    } catch (error) {
      return handleApiError(error);
    }
    return { success: false, data: null, status: 400 };
  }
  
  

  async function dispatchDeleteQuizz(id: number): Promise<APIResponse<null>> {
    try {
      const { status } = await API.quizz.deleteQuizz(id)
      if (status === 200) {
        removeQuizz(id)
        return { success: true, data: null }
      }
    } catch (error) {
      return handleApiError(error)
    }
    return { success: false, data: null, status: 400 }
  }

  async function dispatchUpdateQuizz(input: InputUpdateQuizz): Promise<APIResponse<null>> {
    console.log('Input sent to update API:', input);
    try {
      const { status, data } = await API.quizz.updateQuizz(input);
      console.log('API Response:', status, data);
      if (status === 200 && data.data) {
        updateQuizzInStore(data.data); // Mise à jour du quiz dans l'état
        return { success: true, data: null };
      }
    } catch (error) {
      console.error('Error updating quiz:', error);
      return handleApiError(error);
    }
    return { success: false, data: null, status: 400 };
  }
  

  return {
    quizzs,
    initQuizzs,
    addNewQuizz,
    removeQuizz,
    dispatchGetQuizzs,
    dispatchCreateQuizz,
    dispatchDeleteQuizz,
    dispatchUpdateQuizz,
  }
})
