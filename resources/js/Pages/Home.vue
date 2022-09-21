<template>
  <Head>
    <title>Home</title>
    <meta
      type="description"
      content="Home information"
      head-key="description"
    />
  </Head>

  <h1 class="text-3xl">Home</h1>

  <pre>
    <code>
        class Example
        {
            public fucntion __construct()
            {
                //
            }
        }
    </code>
  </pre>
</template>
<script>
import hljs from "highlight.js";
import "highlight.js/styles/github-dark.css";

export default {
  mounted() {
    hljs.highlightAll();
  },
};
</script>
<!-- <script>
import Layout from "../Shared/Layout";
export default {
  layout: Layout
};
</script> -->


<!-- <template>
  <Layout>
    <h1 class="text-3xl">
      Home
    </h1>
  </Layout>
</template>

<script setup>
import Layout from "../Shared/Layout";
// export default {
//   components: { Layout },
// };
</script> -->
