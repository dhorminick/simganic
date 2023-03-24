<?php

$OneStarSQL = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND _stars = 'width-20percent'";
$OneStarResult = $con->query($OneStarSQL);
$OneStar = mysqli_num_rows($OneStarResult);

$TwoStarSQL = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND _stars = 'width-40percent'";
$TwoStarResult = $con->query($TwoStarSQL);
$TwoStar = mysqli_num_rows($TwoStarResult);

$ThreeStarSQL = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND _stars = 'width-60percent'";
$ThreeStarResult = $con->query($ThreeStarSQL);
$ThreeStar = mysqli_num_rows($ThreeStarResult);

$FourStarSQL = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND _stars = 'width-80percent'";
$FourStarResult = $con->query($FourStarSQL);
$FourStar = mysqli_num_rows($FourStarResult);

$FiveStarSQL = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND _stars = 'width-100percent'";
$FiveStarResult = $con->query($FiveStarSQL);
$FiveStar = mysqli_num_rows($FiveStarResult);

if ($AllReviewsCount <= 0) {
                                            $OneStarPercentage = 0;
                                            $TwoStarPercentage = 0;
                                            $ThreeStarPercentage = 0;
                                            $FourStarPercentage = 0;
                                            $FiveStarPercentage = 0;
                                            $AverageRating = 0;
                                            $AveragePercentage = 0;
                                        }else{
                                            $OneStarPercentage = (intval($OneStar) / $AllReviewsCount) * 100;
                                            $TwoStarPercentage = (intval($TwoStar) / $AllReviewsCount) * 100;
                                            $ThreeStarPercentage = (intval($ThreeStar) / $AllReviewsCount) * 100;
                                            $FourStarPercentage = (intval($FourStar) / $AllReviewsCount) * 100;
                                            $FiveStarPercentage = (intval($FiveStar) / $AllReviewsCount) * 100;

                                            $AverageRating = (($OneStar * 1) + ($TwoStar * 2) + ($ThreeStar * 3) + ($FourStar * 4) + ($FiveStar * 5)) / ($OneStar + $TwoStar + $ThreeStar + $FourStar + $FiveStar);
                                            $AveragePercentage = ($AverageRating / 5) * 100;
                                        }
?>
