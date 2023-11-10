import Tool from './pages/Tool'
import EditQuiz from './pages/EditQuiz'

Nova.booting((app, store) => {
  Nova.inertia('Quiz', Tool)
  Nova.inertia('EditQuiz', EditQuiz)
})
