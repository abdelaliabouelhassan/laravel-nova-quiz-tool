<template>
  <div class="my-component-scoped">
    <Head title="Quiz" />

    <Heading class="mb-6">Quiz</Heading>

    <Card
      class=" w-full p-5"
    >
       
    <div class=" flex flex-col items-start space-y-8 w-full">
        <div class=" w-full space-y-5">
            <div class=" flex flex-col items-start space-y-2 max-w-lg w-full">
              <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an Course</label>
              <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Choose a country</option>
                <option value="US">United States</option>
                <option value="CA">Canada</option>
                <option value="FR">France</option>
                <option value="DE">Germany</option>
              </select>
            </div>
            <button @click="openModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"> Add New Question</button>
        </div>
        <div class=" w-full space-y-4">
          <h1 class=" text-xl font-bold">Questions List</h1>
          <QuestionCard />
           <QuestionCard /> <QuestionCard />
        </div>

        <div class=" w-full">
           <button @click="openModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit Quiz</button>
        </div>

     </div>
    </Card>
    <AddQuestionModal  ref="AddQuestionModalRef" />
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import AddQuestionModal  from '../components/AddQuestionModal.vue'
import QuestionCard from '../components/QuestionCard.vue'

const AddQuestionModalRef = ref(null)

 const openModal = () => {
  AddQuestionModalRef.value.open = true;
 }
</script>

<style>
/* Scoped Styles */
</style>
