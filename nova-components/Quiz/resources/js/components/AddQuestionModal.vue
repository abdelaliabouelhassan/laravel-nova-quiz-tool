<template>
  <div
   v-if="open"
    class="relative z-10"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div
      class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
    ></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div
        class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
      >
        <div
          class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl"
        >
          <div class="relative w-full max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 space-y-5">
                
                <div class=" w-full p-5 space-y-6">
                    <div class=" w-full space-y-4">
                   
                        <div class="flex flex-col items-start space-y-2  w-full">
                        <label for="Question" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type Question</label>
                        <input v-model="question.questions[QuestionIndex].question" type="text" id="Question" class=" outline-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Question...?" required>
                    </div>
                    <div class="flex items-center mb-4">
                            <input v-model="question.questions[QuestionIndex].has_comment" id="Comment" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="Comment" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Has Comment?</label>
                    </div>
                    <div class="flex items-center mb-4">
                            <input v-model="question.questions[QuestionIndex].graded" id="Graded" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="Graded" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Graded?</label>
                    </div>
                    </div>
                    <div class=" w-full flex flex-col items-start space-y-5">
                        <div class=" flex items-center space-x-4 w-full" v-for="(item,index,key) in question.questions[QuestionIndex].questions" :key="key">
                            <div class=" w-full max-w-lg">
                                <input v-model="item.answer" type="text" class="  outline-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" :placeholder="'Answer ' + (index + 1)" required> 
                            </div>
                            <div class=" w-fit flex items-center space-x-2">
                                <input v-model="item.is_correct" @change="SetIsCorrect(item)" :value="true" type="radio"  name="qs" class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <button @click="RemoveAnswer(item)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" text-red-600 w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            </div>
                        </div>
    
                    </div>
                    <button @click="addAnswer" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 uppercase font-bold">Add Answer</button>
                </div>
               
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button @click="Save" data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 uppercase">Save Changes</button>
                    <button @click="Cancel" data-modal-hide="default-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 uppercase">Cancel</button>
                </div>
          
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
 import { onMounted, ref,defineExpose } from "vue";
 const props = defineProps({
    question: {
      type: Object,
      required: false,
    },
    QuestionIndex:{
      type:Number,
      required:false
    }
  })
 const open = ref(false)

 const addAnswer = () => {
  props.question.questions[props.QuestionIndex].questions.push({
    answer:'',
    is_correct:false
  })
 }

 const SetIsCorrect = (item) => {

  props.question.questions[props.QuestionIndex].questions.forEach(element => {
    element.is_correct = false
  });
  item.is_correct = true
  
  }

  const Save = () => {
    //validate question if set is correct 
    let is_correct = props.question.questions[props.QuestionIndex].questions.find(item => item.is_correct == true)
  
    //validate question if has question
    if(props.question.questions[props.QuestionIndex].question == ''){
      alert('Please enter a question')
      return
    }

    if(!is_correct){
      alert('Please select a correct answer')
      return
    }

    //validate question if has answer
    let has_answer = props.question.questions[props.QuestionIndex].questions.find(item => item.answer == '')
    if(has_answer){
      alert('Please enter an answer')
      return
    }

    open.value = false

  }

  const RemoveAnswer = (item) => {
    let index = props.question.questions[props.QuestionIndex].questions.indexOf(item)
    props.question.questions[props.QuestionIndex].questions.splice(index,1)

  }

  const Cancel = () => {
    if(confirm('Are you sure you want to cancel? it will remove all the data you have entered')){
      let index = props.question.questions.indexOf(props.question.questions[props.QuestionIndex])
      props.question.questions.splice(index,1)


       open.value = false
      
    }
    
  }



  defineExpose({
    open
 })

 
</script>