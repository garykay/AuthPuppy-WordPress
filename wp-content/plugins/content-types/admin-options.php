<?php
?>

<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<h1>Nouveau contenu</h1>
    <ul>
        <li><label for="name">Nom<span> *</span>: </label>
        <input id="name" maxlength="45" size="10" name="fname" value="" /></li>    
 
        <li><label for="html_content">Contenu (HTML)<span> *</span>: </label>
        <input id="html_content" maxlength="45" size="10" name="lname" value="" /></li>
    </ul>
</form

<table class="widefat">
<thead>
    <tr>
        <th>Nom</th>
        <th>Content</th>
    </tr>
</thead>
<tfoot>
    <tr>
    <th>Nom</th>
    <th>Content</th>
    </tr>
</tfoot>
<tbody>
   <tr>
     <td><?php echo $regid; ?></td>
     <td><?php echo $name; ?></td>
   </tr>
</tbody>
</table>
<?php