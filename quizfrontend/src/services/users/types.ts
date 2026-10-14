// types.ts pour le service User

// Typage de base pour un utilisateur
export type User = {
  id: number
  username: string
  email: string
  role: string
  created_at: string
  updated_at: string
}

// Typage pour les réponses de l'utilisateur (UserResponse)
export type UserResponse = {
  id: number
  user_id: number
  question_id: number
  answer_option_id: number
  is_correct: boolean
  created_at: string
  updated_at: string
}

// Typage pour les résultats de quiz de l'utilisateur (QuizzResult)
export type QuizzResult = {
  id: number
  user_id: number
  quizz_id: number
  score: number
  created_at: string
  updated_at: string
}

// Typage pour créer un nouvel utilisateur
export type InputCreateUser = {
  username: string
  email: string
  password: string
  role: string
}

// Typage pour mettre à jour un utilisateur
export type InputUpdateUser = {
  id: number
  username?: string
  email?: string
  role?: string
}

// Typage pour la connexion de l'utilisateur
export type InputLogin = {
  email: string
  password: string
}
