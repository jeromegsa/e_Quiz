// Type pour une option de réponse
export type AnswerOption = {
  id?: number
  content: string
  is_correct: boolean // Indique si l'option est correcte ou non
}

// Type pour une Question sans inclure 'userResponses'
export type Question = {
  id?: number
  libelle: string // Titre de la question
  quizz_id?: number // ID du quiz auquel la question est liée
  content: string // Contenu de la question
  question_type: 'multiple_choice' | 'single_choice' | 'text'|'vrai_faux' // Type de la question
  points: number // Points attribués pour cette question
  duration: number
  image_url?: string // URL de l'image (facultatif)
  answer_options: AnswerOption[] // Les options de réponse associées
}

// Type pour créer une nouvelle Question
export type InputCreateQuestion = {
  libelle: string
  quizz_id?: number // Le quizz auquel la question est liée
  content: string
  question_type: 'multiple_choice' | 'single_choice' | 'text' | 'vrai_faux'
  points: number
  duration: number
  image_url?: File // Optionnel
  answer_options: InputCreateAnswerOption[] // Création des options de réponse
}

// Type pour mettre à jour une Question
export type InputUpdateQuestion = {
  id?: number // Nécessaire pour identifier la question à mettre à jour
  libelle?: string // Facultatif, pour les mises à jour partielles
  content?: string
  question_type?: 'multiple_choice' | 'single_choice' | 'text' | 'vrai_faux'
  points?: number
  duration?: number
  image_url?: string
  answer_options?: InputUpdateAnswerOption[] // Mise à jour des options de réponse
}

// Types pour créer ou mettre à jour une option de réponse
export type InputCreateAnswerOption = {
  content: string
  is_correct: boolean
}

export type InputUpdateAnswerOption = {
  id?: number // Facultatif, nécessaire lors de la mise à jour
  content?: string // Facultatif pour mise à jour partielle
  is_correct?: boolean // Facultatif pour mise à jour partielle
}
