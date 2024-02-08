<template>
    <b-form class="border-2 border-secondary rounded-lg p-2 mb-4">
        <b-form-group label="Detail">
            <b-form-input v-model="value.description"></b-form-input>
        </b-form-group>
        <div class="d-flex gap-x-2">
            <b-form-group label="Month" class="w-33">
                <div class="d-flex gap-x-2">
                    <b-form-select class="w-50" v-model="selectedMonth" :options="monthOptions"/>
                    <b-form-input v-model="selectedYear" class="w-50" type="number" :min="(new Date()).getFullYear() - 1"/>
                </div>
            </b-form-group>
            <b-form-group label="Category" class="w-33">
                <b-select v-model="selectedCategory" :options="categories" text-field="name" value-field="id">
                    <template #first><b-form-select-option :value="null" disabled>-- Select a Category -- </b-form-select-option></template>
                </b-select>
            </b-form-group>
            <b-form-group label="Sub-category" class="w-33">
                <b-select v-model="value.sub_category_id" :options="subCategoryOptions" text-field="name" value-field="id">
                    <template #first><b-form-select-option :value="null" disabled>-- Select a Sub Category -- </b-form-select-option></template>
                </b-select>
            </b-form-group>
        </div>
        <div class="d-flex justify-content-end align-items-center">
            <b-form-group label="Amount" class="w-33">
                <b-input type="number" v-model="value.amount" :disabled="!subDivideAmount"></b-input>
            </b-form-group>
        </div>
    </b-form>
</template>

<script>
export default {
    name: "CategorizeTransactionsEntry",
    props:{
        value: {
            description: String,
            month: String,
            sub_category_id: [Number,String],
            amount: [Number,String],
            one_time: Boolean,
        },
        categories: Array,
        subDivideAmount: Boolean,
    },
    data(){return{
        selectedCategory: null,
        selectedYear: (new Date()).getFullYear(),
        selectedMonth: Number(this.value.month.slice(5,7)),
        monthOptions: [
            'January','February','March','April',
            'May','June','July','August',
            'September','October','November','December'
        ].map((value,index)=>{return {text: value, value: index+1}}),
    }},
    computed:{
        subCategoryOptions(){
            return this.categories.find((item)=>item.id == this.selectedCategory)?.sub_categories ?? [];
        },
    },
    methods:{
        composeMonth(){
            this.value.month = `${this.selectedYear}-${('0'+this.selectedMonth).slice(-2)}-01`;
        }
    },
    watch:{
        value: {
            handler(){
                this.$emit('input',this.value);
            },
            deep: true,
        },
        selectedYear(){
            this.composeMonth();
        },
        selectedMonth(){
            this.composeMonth();
        }
    }
}
</script>
