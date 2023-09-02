<script>
export default {
    name: "monthly-breakdown",
    data(){return{
        incomeItems: [
            {
                name: 'Income', 
                amount: 4890, 
                sub_categories: [
                    {name: "Pedestal PRO", amount: 4890}
                ],
            },
        ],
        expenseItems: [
            {
                name: 'Bills', 
                amount: 2200,
                sub_categories: [
                    {name: "Mortgage", amount: 1800},
                    {name: "Power", amount: 150},
                    {name: "Utilities", amount: 50},
                    {name: "Internet", amount: 60},
                    {name: "Phone", amount: 140},
                ]
            },
            {
                name: 'Food', 
                amount: 540,
                sub_categories: [
                    {name: "Groceries", amount: 360},
                    {name: "Eat Out", amount: 120},
                    {name: "Snacks", amount: 60},
                ]
            },
            {
                name: 'Car', 
                amount: 320,
                sub_categories: [
                    {name: "Gas", amount: 300},
                    {name: "Maintenance", amount: 20},
                ]
            },
        ],
        fields: [
            {
                key: "name",
            },
            {
                key: 'amount',
                formatter: this.formatCurrency,
                tdClass: "w-25 text-right pr-5",
            }
        ],
        netIncome: 250 //eventually calculate based on diff between income and expenses
    }},
    methods:{
        formatCurrency(amount){
            return Number(amount).toLocaleString("en-us",{ style: 'currency', currency: 'USD', roundingMode: 'halfExpand' });
        },
        toggleRowDetails(rowItem){
            this.$set(rowItem, '_showDetails', !rowItem._showDetails);
        }
    }
}
</script>

<template>
    <div class="bg-secondary rounded-lg h-100 d-flex flex-column">
        <div class="p-2 mb-4 d-flex justify-content-end align-items-center">
            <div class="mr-2">Data from January - August</div>
            <b-select :value="2023" :options="[{text: 2023, value: 2023}]" class="w-25 bg-primary text-light"></b-select>
        </div>
        <div class="p-2 overflow-auto h-100 border-top border-bottom border-white">
            <h2>Income</h2>
            <b-table :items="incomeItems" :fields="fields" style="font-size: 1.5rem;" thead-class="d-none" hover @row-clicked="toggleRowDetails">
                <template #row-details="row">
                    <div v-for="sub in row.item.sub_categories" :key="sub.name" class="d-flex ml-5" style="font-size: 1rem;">
                        <div class="flex-grow-1">{{sub.name}}</div>
                        <div class="w-25 text-right pr-5">{{formatCurrency(sub.amount)}}</div>
                    </div>
                </template>
            </b-table>
            <h2 class="mt-3">Expenses</h2>
            <b-table :items="expenseItems" :fields="fields" style="font-size: 1.5rem;" thead-class="d-none" hover @row-clicked="toggleRowDetails">
                <template #row-details="row">
                    <div v-for="sub in row.item.sub_categories" :key="sub.name" class="d-flex ml-5" style="font-size: 1rem;">
                        <div class="flex-grow-1">{{sub.name}}</div>
                        <div class="w-25 text-right pr-5">{{formatCurrency(sub.amount)}}</div>
                    </div>
                </template>
            </b-table>
        </div>
        <div class="text-right p-2 mr-5" :class="[netIncome < 0 ? 'text-danger' : 'text-success']" style="font-size: 2rem;">Net: {{ formatCurrency(netIncome) }}</div>
    </div>
</template>