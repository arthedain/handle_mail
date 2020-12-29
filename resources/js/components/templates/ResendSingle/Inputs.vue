<template>
    <div>
        <div v-for="(input, key, index) in mailContent" :key="index" class="flex py-6 px-8 items-center mb-3 border-b border-40">
            <div class="flex-row w-full">
                <div class="flex mb-4">
                    <label  class="inline-block text-80 pt-2 leading-tight w-1/5 mb-2">{{__('Key')}}</label>
                    <input type="text" :value="__(input.key)" class="w-full form-control form-input form-input-bordered">
                </div>
                <div class="flex mb-2">
                    <label  class="inline-block text-80 pt-2 leading-tight w-1/5 mb-2">{{__('Value')}}</label>
                    <input type="text" :value="input.value" class="w-full form-control form-input form-input-bordered">
                </div>
            </div>
            <div class="ml-4" @click="removeMailContent(input.key)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
            </div>
        </div>
        <div class="w-full flex">
            <button @click="addMailContent" class="btn btn-default btn-teal m-auto mr-4 mb-2">Add new field</button>
        </div>
    </div>
</template>

<script>
  export default {
    name: "Inputs",
      props: ['mailContent'],
      // data(){
      //   return {
      //       mailContent: [],
      //
      //   }
      // },
      methods: {
          addMailContent() {
              this.mailContent.push({
                  key: `key ${this.mailContent.length + 1}`,
                  value: ''
              });
          },
          removeMailContent(key) {
              this.mailContent = this.mailContent.map((item) => {
                  if(item.id !== key) {
                      return item;
                  }
              });
              // _.remove(this.mailContent, item => {
              //     return item.key === key;
              // });
              console.log(this.mailContent);
          },
      }
  }
</script>

<style scoped>

</style>
