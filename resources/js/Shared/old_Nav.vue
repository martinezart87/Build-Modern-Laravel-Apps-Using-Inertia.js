<template>
  <nav class="mt-6">
    <ul class="list-disc">
      <li><Link
        href="/"
        class="text-blue-500 hover:underline"
        :class="{'font-bold underline': $page.component === 'Home'}"
        >Home</Link></li>

      <li><NavLink href="/" :active="$page.component === 'Home'">Home</NavLink></li>

      <li><Link href="/users" class="text-blue-500 hover:underline" :class="{'font-bold underline': $page.component === 'Users'}">Users</Link></li>
      <li><Link href="/settings" class="text-blue-500 hover:underline" :class="{'font-bold underline': $page.component === 'Settings'}">Settings</Link></li>
      <li><Link href="/welcome" class="text-blue-500 hover:underline" :class="{'font-bold underline': $page.component === 'Welcome'}">Welcome</Link></li>
      <li><Link :data="{ foo: 'bar' }" href="/logout" method="post" as="button" class="text-blue-500 hover:underline">Log out</Link></li>
    </ul>
  </nav>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
import { NavLink } from "./NavLink";

export default {
  components: { Link, NavLink },
};
</script>
