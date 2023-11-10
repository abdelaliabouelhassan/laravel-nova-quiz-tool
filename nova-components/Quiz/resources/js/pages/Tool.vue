<template>
  <div class="tool-quiz">
    <Head title="Create Quiz" />


   <div class=" w-full flex items-center justify-between">
     <Heading class="mb-6">Create Quiz</Heading>
    <inertia-link href="quiz/edit" class="text-2xl font-bold underline text-blue-500">
      Edit Quiz
    </inertia-link>
   </div>

    <Card
      class=" w-full p-5 dark:bg-gray-800 relative"
    >

    <div class=" absolute top-2 right-2">
      <span class=" text-blue-600 font-bold text-xl">Count of Filled Courses : ({{Questions.length}})</span> 
    </div>

    <div class=" flex flex-col items-start space-y-8 w-full">
        <div class=" w-full space-y-5">
            <div class=" flex flex-col items-start space-y-2 max-w-lg w-full">
              <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an Course</label>
              <select  v-model="selectedCourse" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option :value="item.id" v-for="(item,index,key) in courses" :key="key">{{item.title}}</option>
              </select>
            </div>
            <button @click="openModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"> Add New Question</button>
        </div>
        <div class=" w-full space-y-4" v-if="selectedQuestions">
          <h1 class=" text-xl font-bold">Questions List</h1>
          <QuestionCard v-for="(item,index,key) in selectedQuestions.questions" :index='index' :question='item' :key="key">
              <div class=" w-full flex space-x-2 items-center justify-end">
                  <button @click="Edit(index)" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</button>
                  <button @click="Delete(index)" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
              </div>
          </QuestionCard>
         
        </div>

        <div class=" w-full">
           <button @click="Save"  type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit Quiz</button>
        </div>
        

     </div>
    </Card>
    <AddQuestionModal :question='selectedQuestions' :QuestionIndex='QuestionIndex'  ref="AddQuestionModalRef" />
  </div>
</template>

<script setup>
import axios from 'axios'
import { onMounted, ref,computed,watch } from "vue";
import AddQuestionModal  from '../components/AddQuestionModal.vue'
import QuestionCard from '../components/QuestionCard.vue'
const courses = ref([]);
const AddQuestionModalRef = ref(null)
const selectedCourse = ref(null)
const Questions = ref([])
const QuestionIndex = ref(0)
 const openModal = () => {
  //add question 
  if(selectedCourse.value == null){
    alert('Please select a course')
    return
  }
    //check if course id exsits on questions array
    let course = Questions.value.find(item => item.course_id == selectedCourse.value)
    if(!course){
      QuestionIndex.value = 0
        Questions.value.push({
        course_id:selectedCourse.value,
        questions:[{
          question:'',
          has_comment:false,
          graded:false,
          answers:[],
        }],
        
      })
    }else{
      QuestionIndex.value = course.questions.length

      course.questions.push({
        question:'',
        has_comment:false,
        graded:false,
        answers:[],
      })
    }
   

    AddQuestionModalRef.value.open = true;
 }



  const selectedQuestions = computed(() => { 
    return Questions.value.find(item => item.course_id == selectedCourse.value)
  })


  const Edit = (index) => {
    QuestionIndex.value = index
      AddQuestionModalRef.value.open = true;
  }

  const Delete = (index) => {
    let course = Questions.value.find(item => item.course_id == selectedCourse.value)
    course.questions.splice(index,1)
  }


watch(() => Questions.value, (newVal, oldVal) => {
  //if question is empty remove course
  let course = Questions.value.find(item => item.course_id == selectedCourse.value)
  if(course){
    if(course.questions.length == 0){
      let Question_Index = Questions.value.indexOf(course)
      Questions.value.splice(Question_Index,1)
    }
  }
  //deep
}, { deep: true })
  
  

  const loadCourses = () => {
    axios.get('/nova-vendor/quiz/courses').then((response) => {
      console.log(response.data)
      courses.value = response.data
    })
  }
   const Save = () => {
    if(Questions.value.length == 0){
      alert('Please add a question')
      return
    }else if(Questions.value.length > 0){
      let has_question = Questions.value.find(item => item.questions.length == 0)
      if(has_question){
        alert('Please add a question')
        return
      }
    }
    axios.post('/nova-vendor/quiz/save-quiz', {
      questions: Questions.value
    }).then((response) => {
      console.log(response.data)
      Questions.value = []
      selectedCourse.value = null
      alert('Quiz has been submitted successfully')
      
    }).catch((error) => {
      console.log(error)
      alert('Something went wrong!')
    })
  }
 onMounted(() => {
 
  loadCourses()
 })
</script>

<style>
/* Scoped Styles */
</style>
