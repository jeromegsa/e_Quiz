import { ref } from 'vue'
import quizService from '@/services/quizzs/index'

// Déclaration réactive pour stocker les données
const quizzes = ref<Record<string, any>[]>([]) // Préciser le type ici pour éviter les erreurs

async function fetchQuizzes() {
  try {
    // Attendre la récupération des données
    const quizzs= await quizService.fetchAllQuizz(); // Attendre que la promesse soit résolue
    for (let quiz of quizzs){
      if(quiz.is_active==true){
        quizzes.value.push(quiz)
      }
    }
    console.log("Quizzes:", quizzes.value); // Vérifie les données
  } catch (error) {
    console.error('Erreur lors de la récupération des quizzes:', error)
  }
}

// Appeler la fonction pour récupérer les quizzes au chargement
await fetchQuizzes()

export default quizzes
