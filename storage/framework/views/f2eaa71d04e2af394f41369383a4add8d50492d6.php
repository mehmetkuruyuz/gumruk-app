<tr>
    <td><?php echo e($talimat->kodName); ?>

      <input type="hidden" name="talimatid[]" value="<?php echo e($talimat->kisaKod); ?>" />
    </td>
    <td><input type='text' class="form-control" name="price[]" /></td>
    <td>
      <select name='moneytype[]' class="form-control" >
  			<option value='TL'>TL</option>
  				<option value='EURO'>Euro</option>
  				<option value='DOLAR'>Dolar</option>
  				<option value='POUND'>Pound</option>
      </select>
   </td>
    <td><input type="checkbox" name="toplu[]" value="yes" class="form-control-checkbox" /></td>
    <td>
      <a href="javascript:void(0)" onclick="deleteTableItem(this)"><i class="fa fa-remove" aria-hidden="true"></i></a>
    </td>
  </tr>
