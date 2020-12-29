<template>
    <modal
        data-testid="confirm-action-modal"
        tabindex="-1"
        role="dialog"
        @modal-close="handleClose"
        class-whitelist="flatpickr-calendar"
    >
        <form
            autocomplete="off"
            @keydown="handleKeydown"
            @submit.prevent.stop="handleConfirm"
            class="bg-white rounded-lg shadow-lg overflow-hidden"
        >
            <div>
                <heading :level="2" class="border-b border-40 py-8 px-8">{{ __(title) }}</heading>

                <p class="text-80 px-8 my-8">
                    {{ __('Are you sure you want to run this action?') }}
                </p>
            </div>
<!--            <div class="m-3">-->
<!--                <p class="text-80 m-2">Email</p>-->
<!--                <input type="text" v-model="email" class="w-full form-control form-input form-input-bordered mb-4" placeholder="Email">-->
<!--            </div>-->

            <div class="bg-30 px-6 py-3 flex">
                <div class="flex items-center ml-auto">
                    <button
                        dusk="cancel-action-button"
                        type="button"
                        @click.prevent="handleClose"
                        class="btn text-80 font-normal h-9 px-3 mr-3 btn-link"
                    >
                        {{ __('Cancel') }}
                    </button>

                    <button
                        ref="runButton"
                        dusk="confirm-action-button"
                        :disabled="working"
                        type="submit"
                        class="btn btn-default btn-teal"
                    >
                        <loader v-if="working" width="30"></loader>
                        <span v-else>{{ __('Run Action') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </modal>
</template>

<script>
    export default {
        props: {
            working: Boolean,
            resourceName: { type: String, required: true },
            action: { type: Object, required: true },
            selectedResources: { type: [Array, String], required: true },
            errors: { type: Object, required: true },
            method: { type: Function },
            title: {type: String}
        },
        /**
         * Mount the component.
         */
        mounted() {
            // If the modal has inputs, let's highlight the first one, otherwise
            // let's highlight the submit button
            if (document.querySelectorAll('.modal input').length) {
                document.querySelectorAll('.modal input')[0].focus()
            } else {
                this.$refs.runButton.focus()
            }
        },
        methods: {
            /**
             * Stop propogation of input events unless it's for an escape or enter keypress
             */
            handleKeydown(e) {
                if (['Escape', 'Enter'].indexOf(e.key) !== -1) {
                    return
                }
                e.stopPropagation()
            },
            /**
             * Execute the selected action.
             */
            handleConfirm() {
                this.method();
                this.$emit('confirm');
            },
            /**
             * Close the modal.
             */
            handleClose() {
                this.$emit('close')
            },
        },
    }
</script>

<style>

</style>
