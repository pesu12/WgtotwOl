<i><h2><?=$title?></h2></i>

<table style="width:50%">
  <tr>
    <td>
      Namn: <?=$user->Username?></br>
      Akronym: <?=$user->Acronym?></br>
      Email: <?=$user->Email?></br>
    </td>
    <td>
      <img src=<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->Email ) ) ) . "?d=mm&s=80"?> alt="" />
    </td>
  </tr>
</table>
