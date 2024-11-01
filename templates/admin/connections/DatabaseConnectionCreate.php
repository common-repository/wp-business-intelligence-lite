<?php $this->layout('admin/baseLayout', array('title' => 'Create Database Connection')) ?>
<form id='create-database-connection' action='<?=$this->e($action)?>' method='post'>
  <table class="form-table">
    <tbody>

      <tr>
        <th scope="row"><label for='type'>type</label></th>
        <td>
          <select id='type' name='type'>
            <option value='mysql'>MySQL</option>
          </select>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='name'>name</label></th>
        <td>
          <input id='name' name='name' type="text" class="regular-text"/>
          <p class="description">Name of the connection. A friendly name that's easy to remember.
            Used as a referenced and not parsed.</p>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='username'>username</label></th>
        <td>
          <input id='username' name='username' type="text" class="regular-text"/>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='password'>password</label></th>
        <td>
          <input id='password' name='password' type="text" class="regular-text"/>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='database_name'>database name</label></th>
        <td>
          <input id='database_name' name='database_name' type="text" class="regular-text"/>
          <p class="description">Name of database (not the username)</p>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='host'>host</label></th>
        <td>
          <input id='host' name='host' type="text" class="regular-text"/>
          <p class="description">Often localhost or 127.0.01. May be a url.</p>
        </td>
      </tr>

      <tr class="pureSql">
        <th scope="row"><label for='port'>port</label></th>
        <td>
          <input id='port' name='port' type="text" class="regular-text"/>
          <p class="description">Optional if using default port.</p>
        </td>
      </tr>

      <tr class="pureSql">
        <th scope="row"><label for='socket'>socket</label></th>
        <td>
          <input id='socket' name='socket' type="text" class="regular-text"/>
          <p class="description">This is rarely used and should usually be left empty. Unix socket eg '/tmp/mysql.sock'. If using a socket, leave host and port empty.</p>
        </td>
      </tr>

      <tr class="firebird">
        <th scope="row"><label for='charset'>charset</label></th>
        <td>
          <input id='charset' name='charset' type="text" class="regular-text"/>
        </td>
      </tr>

      <tr class="firebird">
        <th scope="row"><label for='role'>role</label></th>
        <td>
          <input id='role' name='role' type="text" class="regular-text"/>
        </td>
      </tr>

      <tr class="firebird">
        <th scope="row"><label for='dialect'>dialect</label></th>
        <td>
          <input id='dialect' name='dialect' type="text" class="regular-text"/>
        </td>
      </tr>

    </tbody>
  </table>

  <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Create"></p>
</form>

<script type="text/javascript">
  jQuery(document).ready(function($) {

    function toggle_firebird(type) {
      if (type == 'firebird') {
        $('.firebird').show();
        $('.pureSql').hide();
      } else {
        $('.firebird').hide();
        $('.pureSql').show();
      }
    }

    function toggle_sqlite(type) {
      if (type == 'sqlite') {
        $('.firebird, .pureSql').hide();
      } else {
        $('.firebird, .pureSql').show();
      }
    }

    $('.firebird').hide();
    $('.pureSql').show();

    toggle_firebird($('#type').val());
    toggle_sqlite($('#type').val());

    $('#type').on('change', function() {
      var type = $(this).val();
      toggle_firebird(type);
      toggle_sqlite(type);
    });
  });
</script>
