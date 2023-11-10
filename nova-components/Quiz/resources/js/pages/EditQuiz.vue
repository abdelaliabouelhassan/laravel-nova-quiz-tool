<template>
  <div class="tool-quiz">
    <Head title="Edit Quiz" />

   <div class=" w-full flex items-center justify-between">
     <Heading class="mb-6">Edit Quiz</Heading>
    <inertia-link :href="backurl" class="text-2xl font-bold underline text-blue-500">
      Go Back
    </inertia-link>
   </div>

    <Card
      class=" w-full p-5 dark:bg-gray-800 relative"
    >

  

    <div class=" flex flex-col items-start space-y-8 w-full">
        <div class=" w-full space-y-5">
            <div class=" flex flex-col items-start space-y-2 max-w-lg w-full">
              <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an Course</label>
              <select @change="getQuiz"  v-model="selectedCourse" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option :value="item.id" v-for="(item,index,key) in courses" :key="key">{{item.title}}</option>
              </select>
            </div>
        </div>
        <div class=" w-full space-y-4" v-if="Questions.length > 0">
          <h1 class=" text-xl font-bold">Questions List</h1>
          <QuestionCard :is_edit='true' v-for="(item,index,key) in Questions" :index='index' :question='item' :key="key">
            
              <div class=" w-full flex space-x-2 items-center justify-end">
                
                  <button @click="Edit(item)" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</button>
                  <button @click="Delete(item,index)" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
              </div>
          </QuestionCard>
         
        </div>

        <div class=" w-full" v-if="Questions.length > 0">
           <button @click="Update"  type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update Quiz</button>
        </div>
        

     </div>
    </Card>
    <EditQuestionModal :question='selectedQuestion' ref="EditQuestionModalRef" />
  </div>
</template>

<script setup>
defineProps({ backurl: String })
import axios from 'axios'
import { onMounted, ref,computed,watch } from "vue";
import EditQuestionModal  from '../components/EditQuestionModal.vue'
import QuestionCard from '../components/QuestionCard.vue'
const courses = ref([]);
const EditQuestionModalRef = ref(null)
const selectedCourse = ref(null)
const Questions = ref([])
const selectedQuestion = ref({})

 
 const getQuiz = () => {
   axios.get('/nova-vendor/quiz/get-quiz/'+selectedCourse.value).then((response) => {
     console.log(response.data)
     Questions.value = response.data
   })
 }




  const Edit = (item) => {
      selectedQuestion.value = item
      EditQuestionModalRef.value.open = true;
  }

  const Delete = (item,index) => {
    if(confirm('Are you sure you want to delete this question?')){
      axios.post('/nova-vendor/quiz/delete-question', {
        id: item.id
      }).then((response) => {
        console.log(response.data)
        Questions.value.splice(index,1)
      })
    }
   

  }


  
  

  const loadCourses = () => {
    axios.get('/nova-vendor/quiz/courses').then((response) => {
      console.log(response.data)
      courses.value = response.data
    })
  }
   const Update = () => {
      axios.post('/nova-vendor/quiz/update-quiz', {
        course_id: selectedCourse.value,
        questions:Questions.value
      }).then((response) => {
        console.log(response.data)
        alert('Quiz Updated Successfully')
      })
   }
 onMounted(() => {
 
  loadCourses()
 })
</script>

<style>
/* Scoped Styles */
</style>
