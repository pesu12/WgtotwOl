<h1><?=$title?></h1>

<table style="width:100%">
  <tr>
    <td>
      Name: <?=$user->Username?></br>
      Acronym: <?=$user->Acronym?></br>
      Email: <?=$user->Email?></br>
    </td>
    <td>
      <img src=<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->Email ) ) ) . "?d=mm&s=80"?> alt="" />
    </td>
  </tr>
</table>
</br>
