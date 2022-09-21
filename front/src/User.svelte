<script>
  import { users } from './data-users.js'
  export let user = {}
  const imgPath = 'http://localhost/image_upload/back/pictures/'
  let txtFile, txtPicture

  const updateName = async () => {
    const updateRoute = 'http://localhost/image_upload/back/update-user-name.php'
    const data = new FormData()
    data.append('name', user.name)
    data.append('id', user.id)

    let res = await fetch(updateRoute, {
      method: 'POST',
      body: data,
    })
  }

  const updateImage = async () => {
    let picture = new FileReader()
    picture.onload = async (e) => {
      txtPicture.setAttribute('src', e.target.result)
      console.log(e)
      console.log(txtPicture)
      const updateRoute = 'http://localhost/image_upload/back/update-user-picture.php'
      const data = new FormData()
      data.append('picture', txtFile.files[0])
      data.append('id', user.id)

      let res = await fetch(updateRoute, {
        method: 'POST',
        body: data,
      })
    }

    picture.readAsDataURL(txtFile.files[0])
  }

  const deleteUser = async () => {
    const deleteUrl = 'http://localhost/image_upload/back/delete-user.php'
    const data = new FormData()
    data.append('id', user.id)

    let res = await fetch(deleteUrl, {
      method: 'POST',
      body: data,
    })

    $users = $users.filter((item) => user.id !== item.id)
  }
</script>

<div class="user">
  <input type="text" bind:value={user.name} />
  <button on:click={updateName}>등록</button>

  <label for="picture{user.id}">
    <input bind:this={txtFile} type="file" name="picture{user.id}" id="picture{user.id}" on:input={updateImage} />
    <img bind:this={txtPicture} src="{imgPath}{user.picture_name}" alt={user.picture_name} />

    <button on:click={deleteUser}>🗑️</button>
  </label>
</div>

<style>
  .user {
    display: grid;
    grid-template-columns: 100fr 20fr 20fr;
    padding-top: 20px;
  }

  .user img {
    width: 30px;
  }

  input {
    width: 100%;
    border: none;
    outline: none;
    color: black;
    font-size: inherit;
    background-color: transparent;
  }

  button {
    outline: none;
    border: none;
    background: transparent;
  }

  input[type='file'] {
    display: none;
  }
</style>
