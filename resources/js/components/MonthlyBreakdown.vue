<script>
import ExpenseCategoryLine from './sub-components/ExpenseCategoryLine.vue';
import FetchFeedback from './sub-components/FetchFeedback.vue';

export default {
    name: "monthly-breakdown",
    components: { ExpenseCategoryLine, FetchFeedback },
    data(){
        let currentDate = new Date();
        let previousMonth = new Date();
        previousMonth.setMonth(currentDate.getMonth() - 1);
        return{
            selectedMonth: previousMonth.getMonth(),
            selectedYear: previousMonth.getFullYear(),
            incomeItems: [],
            expenseItems: [],
            allItems: [],
            monthOptions: [
                'January','February','March','April',
                'May','June','July','August',
                'September','October','November','December'
            ].map((value,index)=>{return {text: value, value: index}}),
        }
    },
    computed:{
        netIncome(){
            let black = _.reduce(this.incomeItems, (acc,item)=>acc + Number(item.category_total_raw),0);
            let red = _.reduce(this.expenseItems,(acc,item)=>acc + Number(item.category_total_raw),0);
            console.log(black,red);
            return (black + red).toFixed(2);
        }
    },
    mounted(){
        this.fetchExpenses();
    },
    methods:{
        fetchExpenses(){
            axios.get('/api/expenses/grouped-data', {params: {month: this.selectedMonth + 1, year: this.selectedYear}})
                .then(({data})=>{
                    this.allItems = data;
                    this.incomeItems = _.pick(data,['Income']);
                    this.expenseItems = _.omit(data,['Income']);
                }).catch(this.$refs.feedback.error);
        },
        formatCurrency(amount){
            return Number(amount).toLocaleString("en-us",{ style: 'currency', currency: 'USD', roundingMode: 'halfExpand' });
        },
        toggleRowDetails(rowItem){
            this.$set(rowItem, '_showDetails', !rowItem._showDetails);
        }
    },
    watch:{
        selectedMonth(){
            this.fetchExpenses();
        },
        selectedYear(){
            this.fetchExpenses();
        }
    }
}
</script>

<template>
    <div>
        <div class="p-2 mb-2 d-flex align-items-center bg-secondary rounded-lg">
            <b-select v-model="selectedMonth" :options="monthOptions" class="w-25"></b-select>
            <b-input type="number" v-model="selectedYear" :max="(new Date()).getFullYear() + 1" class="w-25"></b-input>
            <div class="text-right pr-2 flex-grow-1 text-right" :class="{'text-danger': netIncome < 0}" style="font-size: 2rem;">Net: {{ formatCurrency(netIncome) }}</div>
        </div>
        <FetchFeedback ref="feedback"/>
        <div class="p-2 border-top border-bottom border-white mt-3">
            <div>
                <h2 class="border-bottom text-center">Income</h2>
                <ExpenseCategoryLine v-for="(item,name) in incomeItems" :key="JSON.stringify(item)" :category="name" :line="item"/>
            </div>
            <div class="mt-3">
                <h2 class="border-bottom text-center">Expenses</h2>
                <ExpenseCategoryLine v-for="(item,categoryName) in expenseItems" :key="JSON.stringify(item)" :category="categoryName" :line="item"/>
            </div>
        </div>
    </div>
</template>