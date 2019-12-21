<?php
/**
 * Created by PhpStorm.
 * User: Roni
 * Date: 12/20/2019
 * Time: 9:08 PM
 */
?>

<div id="app">
    <button id="show-modal" @click="showModal = true">Show Modal</button>
    <!-- use the modal component, pass in the prop -->
    <modal v-if="showModal" @close="showModal = false">
    <!--
      you can use custom content here to overwrite
      default content
    -->
    <h3 slot="header">custom header</h3>
    </modal>
</div>