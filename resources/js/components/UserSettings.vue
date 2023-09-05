<script>
import EditableCategory from './sub-components/EditableCategory.vue';
const categories = [
    {
        id: 1, 
        name: "Bills", 
        enabled: true,
        sub_categories: [
            {
                id: 1,
                name: "Mortgage",
                enabled: true,
            },
            {
                id: 2,
                name: "Internet",
                enabled: true,
            },
            {
                id: 3,
                name: "Power",
                enabled: false,
            }
        ]
    },
    {
        id: 2,
        name: "Clothes",
        enabled: true,
        sub_categories: [
            {
                id: 4,
                name: "Nate",
                enabled: true,
            },
            {
                id: 5,
                name: "Molly",
                enabled: true,
            },
            {
                id: 5,
                name: "Lucas",
                enabled: false,
            },
            {
                id: 6,
                name: "Kids",
                enabled: false,
            }
        ]
    },
    {
        id: 3,
        name: "Food",
        enabled: true,
        sub_categories:[
            {
                id: 7,
                name: "Groceries",
                enabled: true,
            },
            {
                id: 8,
                name: "Eat Out",
                enabled: true,
            },
            {
                id: 9,
                name: "Snacks",
                enabled: false,
            }
        ]
    },
    {
        id: 4,
        name: "Baby",
        enabled: false,
        sub_categories:[
            {
                id: 10,
                name: "Hygiene",
                enabled: false,
            },
            {
                id: 11,
                name: "clothes",
                enabled: false,
            }
        ]
    }
];

export default {
    name: "user-settings",
    components: { EditableCategory },
    data(){return{
        categoriesVisible: false,
        bankAccountsVisible: false,
        showInactive: false,
        activeCategoryId: null,
        enabledCategories: categories.filter((cat)=>cat.enabled),
        disabledCategories: categories.filter((cat)=>!cat.enabled),
    }},
    methods:{
        insertCategory(){
            this.enabledCategories.push({name: null, enabled: true, sub_categories: []});
        },
        insertSubCategory(){
            categories.find((item)=>item.id == this.activeCategoryId).sub_categories.push({name:null, enabled: true})
        }
    },
    computed:{
        activeSubCategories(){
            if (!this.activeCategoryId) return [];
            return categories.find((cat)=>cat.id == this.activeCategoryId).sub_categories;
        }
    }
}
</script>

<template>
    <div>
        <div class="rounded-lg bg-secondary text-dark p-2 mb-4">
            <div class="border border-dark p-2 rounded-lg cursor-pointer">
                <div class="text-lg d-flex gap-x-2 align-items-center" @click="categoriesVisible = !categoriesVisible">
                    <b-icon v-if="categoriesVisible" icon="chevron-down"></b-icon>
                    <b-icon v-else icon="chevron-right"></b-icon>
                    Categories
                </div>
            </div>
            <b-collapse v-model="categoriesVisible">
                <div class="p-4 d-flex">
                    <div class="w-25 d-flex flex-column gap-y-2 pr-4 border-right border-dark">
                        <editable-category v-for="category in enabledCategories" :key="category.id" :value="category" :active="activeCategoryId == category.id" @clicked="activeCategoryId = category.id"></editable-category>
                        <div class="rounded-pill border border-accent bg-accent text-dark px-4 py-2 cursor-pointer active-bg-filter" @click="insertCategory">Add new category +</div>
                        <b-button variant="link" @click="showInactive = !showInactive">{{showInactive ? 'Hide' : 'View'}} Inactive Categories</b-button>
                        <b-collapse v-model="showInactive">
                            <div class="d-flex flex-column gap-y-2">
                                <editable-category v-for="category in disabledCategories" :key="category.id" :value="category" :active="activeCategoryId == category.id" @clicked="activeCategoryId = category.id"></editable-category>
                            </div>
                        </b-collapse>
                    </div>
                    <div v-if="activeSubCategories.length" class="flex-grow-1 pl-4 gap-y-2 gap-x-4" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); grid-auto-rows: min-content; align-items: flex-start;">
                        <editable-category v-for="sub in activeSubCategories" :key="sub.id" :value="sub"></editable-category> 
                        <div class="rounded-pill border border-accent bg-accent text-dark px-4 py-2 cursor-pointer active-bg-filter" @click="insertSubCategory">Add new sub-category +</div>
                    </div>
                </div>
            </b-collapse>
        </div>
        <div class="rounded-lg bg-secondary text-dark p-2">
            <div class="border border-dark p-2 rounded-lg cursor-pointer">
                <div class="text-lg d-flex gap-x-2 align-items-center" @click="bankAccountsVisible = !bankAccountsVisible">
                    <b-icon v-if="bankAccountsVisible" icon="chevron-down"></b-icon>
                    <b-icon v-else icon="chevron-right"></b-icon>
                    Bank Accounts
                </div>
            </div>
            <b-collapse v-model="bankAccountsVisible">Bank account stuff</b-collapse>
        </div>
    </div>
</template>
