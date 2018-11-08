<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.profit.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');

$bllProfit = new BLLProfit;
class BLLProfit
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalProfit = new DALProfit;
		if(isset($_POST['update_profit']))
		{

			$id = $_POST['profitId'];
			$buy = $_POST['buy'];
			$sale = $_POST['sale'];
			
			for($i=1;$i<sizeof($id);$i++)
			{
				//echo $id[$i]."---".$buy[$i]."---".$sale[$i]."<br>";
				$result = $dalProfit->updateProfit($id[$i],$buy[$i],$sale[$i]);
			}

			if($result)
			{
				$_SESSION['message'] = "Profit updated Successfully!";
				header('Location:../profit.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Profit!";
				header('Location:../profit.php');
				exit();
			}

		}
	}
	public function showProfit()
	{
		$totalProfit = 0;
		$data = "";
	
        $dalProfit  = new DALProfit;
        $resultProfit = $dalProfit->showProfit();
        $SL = 1;
        while ($res = mysqli_fetch_assoc($resultProfit))
        {
        	$data .= '<div class="row">';

        $data.=    '<div class="col-md-1">
		            <div class="form-group">
		                <input type="text" name="profitId[]" class="form-control"  value="'.$res["id"].'" style="display:none;">
		            '.$SL++.'.
		            </div>
         		</div>';
        $data.=    '<div class="col-md-3">
		            <div class="form-group">
		              '.$res["subCategoryName"].'
		            </div>
         		</div>';

        $data.=    '<div class="col-md-3">
		            <div class="form-group">
		                <input type="text" name="buy[]" class="form-control"  value="'.$res["buy"].'">
		            </div>
         		</div>';
        $data.=    '<div class="col-md-3">
		            <div class="form-group">
		                <input type="text" name="sale[]" class="form-control"  value="'.$res["sale"].'">
		            </div>
         		</div>';


        	$data .= '</div>';
        }
		return $data;


	}

}
?>