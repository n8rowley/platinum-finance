<template>
    <div>
        <div class="px-4 py-2 bg-secondary text-dark rounded-lg text-lg mb-2">
            <div class="d-flex justify-content-between align-items-center gap-x-2">
                <div>87</div>
                <div> | </div>
                <div class="flex-grow-1">Really long description of what exactly was purchased.</div>
                <div> | </div>
                <div>Account</div>
                <div> | </div>
                <div>DATE</div>
                <div> | </div>
                <div>Amount</div>
            </div>
        </div>
        <div v-for="i in n" :key="i" class="border-2 border-secondary rounded-lg p-2 mb-4">
            <b-form>
                <b-form-group label="Detail">
                    <b-form-input :value="'Really long description of what exactly was purchased.'"></b-form-input>
                </b-form-group>
                <div class="d-flex gap-x-2">
                    <b-form-group label="Month" class="w-33">
                        <b-select :options="months"></b-select>
                    </b-form-group>
                    <b-form-group label="Category" class="w-33">
                        <b-select v-model="selectedCategory" :options="categories"></b-select>
                    </b-form-group>
                    <b-form-group label="Sub-category" class="w-33">
                        <b-select :options="subCategoryOptions"></b-select>
                    </b-form-group>
                </div>
                <b-form-checkbox>One-time transaction</b-form-checkbox>
            </b-form>
        </div>
        <div class="d-flex justify-content-end gap-x-2">
            <b-button>Skip</b-button>
            <b-button @click="n++">Split Transaction</b-button>
            <b-button variant="primary">Submit</b-button>
        </div>
    </div>
</template>

<script>
export default {
    name: "assign-categories",
    data(){return{
        n: 1,
        selectedCategory: 1,
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        categories: [
            {
                text: "Income",
                value: 1,
                sub_categories: [
                    {text: "Pedestal PRO", value: 1},
                ]
            },
            {
                text: "Bills",
                value: 2,
                sub_categories: [
                    {text: "Mortgage", value: 2},
                    {text: "Power", value: 3},
                    {text: "Internet", value: 4},
                    {text: "Utilities", value: 5},
                ]
            },
            {
                text: "Food",
                value: 3,
                sub_categories:[
                    {text: "Groceries", value: 6},
                    {text: "Eat Out", value: 7},
                    {text: "Snacks", value: 8},
                ]
            },
            {
                text: "Car",
                value: 4,
                sub_categories:[
                    {text: "Gas", value: 9},
                    {text: "Maintenance", value: 10},
                ]
            }
        ]
    }},
    computed: {
        subCategoryOptions(){
            return this.categories.find((item)=>item.value == this.selectedCategory).sub_categories;
        }
    }
}
</script>