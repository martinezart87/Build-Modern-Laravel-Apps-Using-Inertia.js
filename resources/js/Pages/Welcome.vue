<template>
    <h1>Vue {{ name }}</h1>
    <p>Framewroks:</p>
    <ul>
        <li v-for="framewrok of frameworks" v-text="framewrok" :key="framewrok.id"></li>
        {{ frameworks }}
    </ul>
</template>
<script>
// jak nie ma zdefiniowanych propsów, to leci jako attrib
    export default {
        props: {
            name: String,
            surname: String,
            frameworks: Array,
        }
    };
</script>
