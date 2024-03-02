<template>
    <div>
        <b-dropdown ref="monthPicker" variant="outline-primary" block menu-class="w-100" no-caret>
            <template #button-content>
                {{ formattedMonth }}
            </template>
            <template #default="hide">
                <b-dropdown-form class="p-0">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <b-button @click="decrementYear">{{ '<' }}</b-button>
                        <div style="font-size: larger;">{{ month.getFullYear() }}</div>
                        <b-button @click="incrementYear">{{ '>'}}</b-button>
                    </div>
                    <div class="mt-2">
                        <div v-for="quarter in quartedMonths" class="d-flex">
                            <div v-for="(name,index) in quarter" class="w-33 m-1">
                                <b-button @click="selectMonth(index, hide)" block :variant="month.getMonth() == index ? 'primary' : 'outline-primary'">
                                    {{ name }}
                                </b-button>
                            </div>
                        </div>
                    </div>
                </b-dropdown-form>
            </template>
        </b-dropdown>
    </div>
</template>

<script>
export default {
    name: "MonthPicker",
    props: {
        value: [String, Object],
        valueAsDate: false,
    },
    data(){
        return {
            visible: false,
            quartedMonths: [
                {0:'January',1:'February',2:'March'},
                {3:'April',4:'May',5:'June'},
                {6:'July',7:'August',8:'September'},
                {9:'October',10:'November',11:'December'}
            ],
        }
    },
    computed: {
        month(){
            if (!this.value) return new Date();
            else if (typeof this.value == 'string') return new Date(this.value + 'T00:00');
            return this.value;
        },
        formattedMonth(){
            return this.month.toLocaleDateString('en-us',{ month: 'long', year: 'numeric' });
        }
    },
    methods: {
        emitDate(date){
            if (this.valueAsDate) {
                this.$emit('input',date)
                return
            } else {
                let temp = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`
                this.$emit('input',temp);
            }
        },
        incrementYear(){
            let nextYear = new Date(this.month);
            nextYear.setFullYear(nextYear.getFullYear() + 1);
            this.emitDate(nextYear);
        },
        decrementYear(){
            let lastYear = new Date(this.month);
            lastYear.setFullYear(lastYear.getFullYear() - 1);
            this.emitDate(lastYear);
        },
        selectMonth(newMonth,hideFunction){
            let newDate = new Date(this.month);
            newDate.setMonth(newMonth);
            this.emitDate(newDate);
            this.$refs.monthPicker.hide(true);
        }

    }
}
</script>

<style lang="scss" scoped>

</style>