<script>
import EditableCategory from './EditableCategory.vue';

export default {
    name: "category-manager",
    components: { EditableCategory },
    data(){return {
        categories: [
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
        ],
        showEnabled: false,
        activeCategory: {},
    }},
    methods:{
        insertCategory(){
            this.categories = [
                ...this.categories,
                {name: null, enabled: true, sub_categories: []},
            ];
        },
        insertSubCategory(){
            this.$set(this.activeCategory, 'sub_categories', [
                ...this.activeCategory.sub_categories,
                {name: null, enabled: true},
            ]);
        }
    },
    computed:{
        activeSubCategories(){
            return this.activeCategory.sub_categories;
        },
        enabledCategories(){
            return this.categories.filter((cat)=>cat.enabled);
        },
        disabledCategories(){
            return this.categories.filter((cat)=>!cat.enabled);
        },
    }
}
</script>

<template>
    <div class="p-4 d-flex">
        <div class="w-25 d-flex flex-column gap-y-2 pr-4 border-right border-dark">
            <editable-category v-for="category in enabledCategories" :key="category.id" :value="category" :active="activeCategory.id == category.id" @clicked="activeCategory = category"></editable-category>
            <div class="rounded-pill border border-accent bg-accent text-dark px-4 py-2 cursor-pointer active-bg-filter" @click="insertCategory">Add new category +</div>
            <b-button variant="link" @click="showEnabled = !showEnabled">{{showEnabled ? 'Hide' : 'View'}} Enabled Categories</b-button>
            <b-collapse v-model="showEnabled">
                <div class="d-flex flex-column gap-y-2">
                    <editable-category v-for="category in disabledCategories" :key="category.id" :value="category" :active="activeCategory.id == category.id" @clicked="activeCategory = category"></editable-category>
                </div>
            </b-collapse>
        </div>
        <div v-if="!!activeSubCategories" class="flex-grow-1 pl-4 gap-y-2 gap-x-4" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); grid-auto-rows: min-content; align-items: flex-start;">
            <editable-category v-for="sub in activeSubCategories" :key="'sub-'+sub.id" :value="sub"></editable-category> 
            <div class="rounded-pill border border-accent bg-accent text-dark px-4 py-2 cursor-pointer active-bg-filter" @click="insertSubCategory">Add new sub-category +</div>
        </div>
    </div>
</template>