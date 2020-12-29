<template>
    <div>
        <div class="flex ">
            <div class="btn-radio">
                <!-- <input
                    id="radio_0"
                    type="checkbox"
                    @change="changeSpam()"
                    name="spam"
                    checked
                ><label for="radio_0" :class="['btn btn-default w-full mt-2 mr-2']">Spam</label> -->
                <input
                    id="radio_1"
                    type="radio"
                    @change="$emit('change')"
                    name="period"
                    checked
                    ref="allData"
                ><label for="radio_1" :class="['btn btn-default w-full mt-2 mr-2']">All</label>
                <input
                    id="radio_2"
                    type="radio"
                    name="period"
                    @change="$emit('change', dayPeriod)"
                ><label for="radio_2" :class="['btn btn-default w-full mt-2 mr-2']">24 hours</label>
                <input
                    id="radio_3"
                    type="radio"
                    name="period"
                    @change="$emit('change', weeksPeriod)"
                ><label for="radio_3" :class="['btn btn-default w-full mt-2 mr-2']">2 weeks</label>
                <input
                    id="radio_4"
                    type="radio"
                    name="period"
                    @change="$emit('change', monthPeriod)"
                ><label for="radio_4" :class="['btn btn-default w-full mt-2 mr-2']">Month</label>
                <input
                    id="radio_5"
                    type="radio"
                    name="period"
                    @change="$emit('change', quarterPeriod)"
                ><label for="radio_5" :class="['btn btn-default w-full mt-2 mr-2']">3 month</label>
                <input
                    id="radio_6"
                    type="radio"
                    name="period"
                    @change="$emit('change', yearPeriod)"
                ><label for="radio_6" :class="['btn btn-default w-full mt-2 mr-2']">Year</label>
            </div>
            <dropdown
                dusk="filter-selector"
                :class="['mt-2 w-full']"
            >
                <dropdown-trigger
                    :class="['bg-30 px-3 border-2 border-30 btn btn-default', activeFilters ? 'btn-teal' : '']"
                >
                    <icon
                        type="filter"
                        :class="'text-80'"
                    />

                    <span class="ml-2 font-bold text-white text-80"></span>
                </dropdown-trigger>

                <dropdown-menu slot="menu" width="290" direction="rtl" :dark="true">
                    <scroll-wrap :height="350">
                        <div class="bg-30 border-b border-60">
                            <button
                                @click="resetFilters"
                                class="py-2 w-full block text-xs uppercase tracking-wide text-center text-80 dim font-bold focus:outline-none"
                            >
                                {{ __('Reset Filters') }}
                            </button>
                        </div>
                        <div>
                            <h3
                                slot="default"
                                class="text-sm uppercase tracking-wide text-80 bg-30 p-3"
                            >
                                {{ __('from') }}
                            </h3>

                            <div class="p-2">
                                <date-time-picker @change="setFrom($event)" v-model="from" ref="fromDate"
                                                  class="block w-full form-control-sm form-select"></date-time-picker>
                            </div>
                        </div>
                        <div>
                            <h3
                                slot="default"
                                class="text-sm uppercase tracking-wide text-80 bg-30 p-3"
                            >
                                {{ __('to') }}
                            </h3>

                            <div class="p-2">
                                <date-time-picker @change="setTo($event)" v-model="to" ref="toDate"
                                                  class="block w-full form-control-sm form-select"></date-time-picker>
                            </div>
                        </div>
                        <div class="bg-30 border-b border-60">
                            <button
                                @click="submit"
                                class="py-2 w-full block text-xs uppercase tracking-wide text-center text-80 dim font-bold focus:outline-none btn-teal"
                            >
                                {{ __('Filter') }}
                            </button>
                        </div>
                    </scroll-wrap>
                </dropdown-menu>
            </dropdown>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Filter",
        data() {
            return {
                from: null,
                to: null,
                activeFilters: 0,
                dayPeriod: {from: moment.utc().subtract(1, 'days').format('YYYY-MM-DD HH:mm:ss')},
                monthPeriod: {from: moment.utc().subtract(30, 'days').format('YYYY-MM-DD HH:mm:ss')},
                weeksPeriod: {from: moment.utc().subtract(14, 'days').format('YYYY-MM-DD HH:mm:ss')},
                quarterPeriod: {from: moment.utc().subtract(3, 'months').format('YYYY-MM-DD HH:mm:ss')},
                yearPeriod: {from: moment.utc().subtract(1, 'years').format('YYYY-MM-DD HH:mm:ss')},
                spam: false,
            }
        },
        methods: {
            resetFilters() {
                this.from = null;
                this.to = null;
                this.activeFilters = 0;
                this.changeCheckedPeriod(true);
                this.submit();
            },
            setFrom(value) {
                this.changeCheckedPeriod(false);
                this.from = value;
                this.activeFilters += 1;
            },
            setTo(value) {
                this.changeCheckedPeriod(false);
                this.to = value;
                this.activeFilters += 1;
            },
            submit() {
                let data = {
                    from: this.from,
                    to: this.to,
                }
                this.$emit('change', data);
            },
            changeCheckedPeriod(status) {
                this.$refs.allData.checked = status;
            },
            changeSpam() {
                this.spam = !this.spam;

                let data = {spam: null};
                
                if(this.spam) {
                    data = {spam: 0};
                }
                
                this.$emit('change', data);
            },
        },
    }
</script>

<style>
    .btn-radio {
        display: flex;
        justify-content: center;
    }

    .btn-radio input {
        opacity: 0;
        position: fixed;
        width: 0;
    }

    .btn-radio label {
        display: inline-block;
        background-color: #f4f7fa;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
    }

    .btn-radio input:checked + label {
        background-color: #38b2ac;
    }
</style>
