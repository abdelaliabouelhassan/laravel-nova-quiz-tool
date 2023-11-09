<template>
    <div class=" w-full rounded-lg border space-y-5 p-4 dark:bg-gray-900 bg-gray-200">        
       <p class=" text-base">
        Question {{index + 1}}:
         <span class=" font-bold">{{question.question}}</span>
       </p>
       <p class=" text-base">
         Answers:
       </p>
        <div class="space-y-4 text-gray-500   dark:text-gray-400">
       
            <ul class="pl-5 mt-2 space-y-1 list-disc list-inside">
                <li :class="{'text-green-400':item.is_correct}" v-for="(item,index,key) in question.questions" :key="key">{{item.answer}}</li>
            </ul>


            <div class=" space-y-2 text-base font-bold">
               <p>Has Comment?:  <span class=" font-normal">{{question.has_comment}}</span></p>
                <p>Is Graded?:  <span  class=" font-normal">{{question.graded}}</span></p>
            </div>
       
        </div>


        <slot />
    </div>
</template>


<script setup>
 const props = defineProps({
    question: {
      type: Object,
      required: false,
    },
    index:{
      type:Number,
      required:false
    }
  })
</script>