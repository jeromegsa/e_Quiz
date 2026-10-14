import quizzesService from './quizzs/index'
import questionsService from './questions/index'

const combinedService = {
  // Quiz functions
  getQuizzes: quizzesService.getQuizzes,
  getQuizz: quizzesService.getQuizz,
  createQuizz: quizzesService.createQuizz,
  updateQuizz: quizzesService.updateQuizz,
  deleteQuizz: quizzesService.deleteQuizz,

  // Question functions
  getQuestions: questionsService.getQuestions,
  getQuestion: questionsService.getQuestion,
  createQuestion: questionsService.createQuestion,
  updateQuestion: questionsService.updateQuestion,
  deleteQuestion: questionsService.deleteQuestion,
}

export default combinedService
