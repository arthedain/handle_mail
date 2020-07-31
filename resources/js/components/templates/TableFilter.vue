<template>
    <div>
        <dropdown
            dusk="filter-selector"
            class="mt-2 w-full"
        >
            <dropdown-trigger
                class="bg-30 px-3 border-2 border-30 rounded"
            >
                <icon
                    type="filter"
                    :class="'text-80'"
                />

                <span  class="ml-2 font-bold text-white text-80"></span>
            </dropdown-trigger>

            <dropdown-menu slot="menu" width="290" direction="rtl" :dark="true">
                <scroll-wrap :height="350">
<!--                    <div class="bg-30 border-b border-60">-->
<!--                        <button-->
<!--                            class="py-2 w-full block text-xs uppercase tracking-wide text-center text-80 dim font-bold focus:outline-none"-->
<!--                        >-->
<!--                            {{ __('Reset Filters') }}-->
<!--                        </button>-->
<!--                    </div>-->

                    <!-- Soft Deletes -->
<!--                    <div>-->
<!--                        <h3-->
<!--                            slot="default"-->
<!--                            class="text-sm uppercase tracking-wide text-80 bg-30 p-3"-->
<!--                        >-->
<!--                            {{ __('Trashed') }}-->
<!--                        </h3>-->

<!--                        <div class="p-2">-->
<!--                            <select-->
<!--                                slot="select"-->
<!--                                class="block w-full form-control-sm form-select"-->
<!--                                dusk="trashed-select"-->
<!--                            >-->
<!--                                <option value="" selected>&mdash;</option>-->
<!--                                <option value="with">{{ __('With Trashed') }}</option>-->
<!--                                <option value="only">{{ __('Only Trashed') }}</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    &lt;!&ndash; Per Page &ndash;&gt;-->
<!--                    <div>-->
<!--                        <h3-->
<!--                            slot="default"-->
<!--                            class="text-sm uppercase tracking-wide text-80 bg-30 p-3"-->
<!--                        >-->
<!--                            {{ __('Per Page') }}-->
<!--                        </h3>-->

<!--                        <div class="p-2">-->
<!--                            <select-->
<!--                                slot="select"-->
<!--                                dusk="per-page-select"-->
<!--                                class="block w-full form-control-sm form-select"-->
<!--                            >-->
<!--                                <option>-->
<!--                                    test 2-->
<!--                                </option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->

                    <div>
                        <h3
                            slot="default"
                            class="text-sm uppercase tracking-wide text-80 bg-30 p-3"
                        >
                            {{ __('From date') }}
                        </h3>

                        <div class="p-2">
                            <date-time-picker @change="fromChange" class="block w-full form-control-sm form-select"></date-time-picker>
                        </div>
                    </div>
                    <div>
                        <h3
                            slot="default"
                            class="text-sm uppercase tracking-wide text-80 bg-30 p-3"
                        >
                            {{ __('To date') }}
                        </h3>

                        <div class="p-2">
                            <date-time-picker @change="toChange" class="block w-full form-control-sm form-select"></date-time-picker>
                        </div>
                    </div>
                </scroll-wrap>
            </dropdown-menu>
        </dropdown>
    </div>
</template>

<script>
    export default {
        name: "Filter",
        props: {
            fromChange: { type: Function },
            toChange: { type: Function }
        },
    }
</script>

<style scoped>

</style>
