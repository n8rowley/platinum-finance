<script>
export default {
    name: "ExpenseCategoryLine",
    props: {
        line: Object,
        category: String,
    },
    data() {
        return {
            subCategoriesVisible: false,
            expensesVisible: false,
        }
    },
}
</script>

<template>
    <div class="mb-2 border-bottom">
        <h4 class="d-flex align-items-center" style="cursor: pointer" @click="subCategoriesVisible = !subCategoriesVisible">
            <div class="flex-grow-1">{{ category }}</div>
            <div class="w-25 text-right pr-5">{{ line.category_total }}</div>
        </h4>
        <b-collapse v-model="subCategoriesVisible" :id="`collapse-${ category }`">
            <template v-for="(data,sub_name,index) in line.sub_categories">
                <div :style="{'background-color': index % 2 == 1 ? '#1E07B01A': 'transparent'}">
                    <h5 class="d-flex align-items-center pl-4" @click="expensesVisible = !expensesVisible" style="cursor: pointer">
                        <div class="flex-grow-1">{{ sub_name }}</div>
                        <div class="w-25 text-right pr-5">{{ data.sub_category_total }}</div>
                    </h5>
                    <b-collapse v-model="expensesVisible" :id="`collapse-${category}-${sub_name}`">
                        <template v-for="expense in data.expenses">
                            <h6 class="d-flex align-items-center" style="margin-left: 3rem;cursor: pointer">
                                <div class="flex-grow-1">{{ expense.expense_name }}</div>
                                <div class="w-25 text-right pr-5">{{ expense.expense_total }}</div>
                            </h6>
                        </template>
                    </b-collapse>
                </div>
            </template>
        </b-collapse>
    </div>
</template>
