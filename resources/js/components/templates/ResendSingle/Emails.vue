<template>
    <div>
        <div v-for="input in inputs" :key="input.id" class="flex py-6 px-8 items-center mb-3 border-b border-40">
            <label :for="input.id" class="inline-block text-80 pt-2 leading-tight w-1/2 mb-2">Email</label>
            <input :id="input.id" type="text" :name="input.name" class="w-full form-control form-input form-input-bordered">
            <div class="ml-2" @click="removeInput(input.id)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
            </div>
        </div>
        <div style="width: 30px; margin-left: auto" @click="addInput">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-9h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2z"/></svg>
        </div>
    </div>
</template>

<script>
  export default {
    name: "Emails",
      data(){
        return {
            inputs: [
                {
                    id: '0',
                    name: 'email_0',
                    value: '',
                }
            ],
        }
      },
      methods: {
          addInput() {
              this.inputs.push({
                  id: this.inputs.length + 1,
                  name: `email_${this.inputs.length + 1}`,
                  value: '',
              });
          },
          removeInput(id) {
              _.remove(this.inputs, item => {
                  return item.id !== id;
              });

          },
      }
  }
</script>

<style scoped>

</style>
