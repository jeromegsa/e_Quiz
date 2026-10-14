// types.ts dans le service Quizz

import type { InputCreateQuestion, Question } from '../questions/types'

// Type pour un Quizz sans l'utilisateur créateur
export type Quizz = {
  id: number
  title: string
  description: string
  is_active: boolean
  duration: number
  image_url: File | string | null
  questions: Question[] // Les questions associées au quiz
}

// Type pour créer un Quizz sans inclure 'created_by'
export type InputCreateQuizz = {
  title: string
  description: string
  is_active: boolean
  duration: number
  image_url?: File | string | null // Permet de gérer les fichiers et les chaînes d'URL
  questions: InputCreateQuestion[]
}


// Type pour mettre à jour un Quizz
export type InputUpdateQuizz = {
  id: number
  title: string
  description: string
  is_active: boolean
  duration: number
  image_url?: File | string | null
}
