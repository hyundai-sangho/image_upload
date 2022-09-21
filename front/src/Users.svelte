<script>
  import User from './User.svelte'
  import { users } from './data-users.js'
  import { onMount } from 'svelte'

  let imageSource = 'pictures/'

  onMount(async () => {
    const url = 'http://localhost/image_upload/back/get-users.php'
    let res = await fetch(url)
    res = await res.json()
    $users = await res.data
  })
</script>

<div id="users">
  {#each $users as user}
    <User {user} />
  {/each}
</div>
