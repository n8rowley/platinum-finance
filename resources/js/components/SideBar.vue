<script>
import {routes} from '../router/vue-routes'
export default {
    name: "side-bar",
    data(){return{
        routes,
    }}
}
</script>

<template>
    <div class="side-bar">
        <ul class="menu">
            <div v-for="route in routes" :key="route.path" class="menu-section">
                <li class="list-category"><router-link :to="route">{{route.name}}</router-link></li>
            </div>
        </ul>
    </div>
</template>