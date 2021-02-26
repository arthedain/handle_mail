<template>
    <div>
        <div class="flex w-full py-4 break-words border-b border-40">
            <div class="w-1/4 py-4">
                <h4 class="font-normal text-80">
                    {{ __('History') }}
                </h4>
            </div>
            <div class="w-3/4 py-4 break-words">
                <p class="text-90">
                    <ul v-show="showText">
                        <li class="mb-1" v-for="(link, key) in links" :key="key">
                            <a class="text-80 breadcrumb" :href="link" target="_blank">{{ link }}</a>
                        </li>
                    </ul>
                    <a aria-role="button" @click="toggleText()" :class="['cursor-pointer dim inline-block teal font-bold', showText ? 'mt-6' : '']">
                        {{ showText ? __('Hide Content') : __('Show Content') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	name: "History",
	props: ["data"],

	data() {
		return {
            tree: [],
            showText: false
		};
	},
	mounted() {},
	methods: {
        toggleText() {
            this.showText = !this.showText;
        },
		treeData() {
			//TODO: make script for sort
			//https://codesandbox.io/s/github/vuejs/vuejs.org/tree/master/src/v2/examples/vue-20-tree-view?from-embed=&file=/index.html
        },
    },
    computed: {
        links(){
            return _.filter(this.data, (item, key) =>  this.data[key-1] !== item);
        }
    },
};
</script>

<style scoped>
ul{
	list-style-type: none;
}
</style>
