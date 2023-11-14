<script>
import EditableCategory from './EditableCategory.vue';

export default {
    name: "category-manager",
    components: { EditableCategory },
    data(){return {
        categories: [],
        showEnabled: false,
        activeCategory: {},
    }},
    created(){
        this.fetchCategoryData();
    },
    methods:{
        fetchCategoryData(){
            axios.get('/api/categories', {params: {with_disabled: true}}).then(({data})=>{
                this.categories = data;
            })
        },
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
        },
        saveCategory(category, payload){
            let method = category.id ? 'PATCH' : 'POST';

            axios({
                url: `/api/categories/${category.id ?? ''}`, 
                data: payload,
                method,
            }).then(({data})=>{
                let index = this.categories.findIndex((item) => item.name == category.name);
                if (index >= 0) this.categories.splice(index,1,data);
            });
        },
        saveSubCategory(subCategory, payload){
            let method = subCategory.id ? 'PATCH' : 'POST';

            axios({
                url: `/api/categories/${this.activeCategory.id}/subCategories/${subCategory.id ?? ''}`,
                method,
                data: payload,
            }).then(({data})=>{
                let index = this.activeCategory.sub_categories.findIndex((item) => item.name == category.name);
                if (index >= 0) this.activeCategory.sub_categories.splice(index,1,data);
            });
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
            <editable-category v-for="category in enabledCategories" 
                :key="category.id" 
                :value="category" 
                :active="activeCategory.id == category.id" 
                @clicked="activeCategory = category"
                @saved="saveCategory(category,$event)"
            />
            <div class="rounded-pill border border-accent bg-accent text-dark px-4 py-2 cursor-pointer active-bg-filter" @click="insertCategory">Add new category +</div>
            <b-button variant="link" @click="showEnabled = !showEnabled">{{showEnabled ? 'Hide' : 'View'}} Enabled Categories</b-button>
            <b-collapse v-model="showEnabled">
                <div class="d-flex flex-column gap-y-2">
                    <editable-category v-for="category in disabledCategories" 
                        :key="category.id" 
                        :value="category" 
                        :active="activeCategory.id == category.id" 
                        @clicked="activeCategory = category"
                        @saved="saveCategory(category,$event)"
                    />
                </div>
            </b-collapse>
        </div>
        <div v-if="!!activeSubCategories && activeCategory.id" class="flex-grow-1 pl-4 gap-y-2 gap-x-4" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); grid-auto-rows: min-content; align-items: flex-start;">
            <editable-category v-for="sub in activeSubCategories" 
                :key="'sub-'+sub.id" 
                :value="sub"
                @saved="saveSubCategory(sub,$event)"
            /> 
            <div class="rounded-pill border border-accent bg-accent text-dark px-4 py-2 cursor-pointer active-bg-filter" @click="insertSubCategory">Add new sub-category +</div>
        </div>
    </div>
</template>
