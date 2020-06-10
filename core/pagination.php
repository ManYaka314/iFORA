<?php
include "connection.php";
$shieldedRequest = mysqli_real_escape_string($connection, "SELECT * FROM feedbacks");
$sql = mysqli_query($connection, $shieldedRequest);

$total = mysqli_num_rows($sql);

$adjacents = 3;
$limit = 10; //how many items to show per page
$page = $_GET['page'];

if ($page) {
    $start = ($page - 1) * $limit; //first item to display on this page
} else {
    $start = 0;
}

/* Setup page vars for display. */
if ($page == 0) {
    $page = 1;
}
//if no page var is given, default to 1.
$prev = $page - 1; //previous page is current page - 1
$next = $page + 1; //next page is current page + 1
$lastpage = ceil($total / $limit); //lastpage.
$lpm1 = $lastpage - 1; //last page minus 1

$sql2 = "select * from feedbacks where 1=1";
$sql2 .= " order by id  limit $start ,$limit ";
$sql_query = mysqli_query($connection, $sql2);

/* CREATE THE PAGINATION */

$pagination = "";
if ($lastpage > 1) {
    $pagination .= "<div class='pagination1'> <ul class=\"pagination pagination-sm justify-content-center\">";
    if ($page > $counter + 1) {
        $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$prev\" class=\"page-link\">&lsaquo;</a></li>";
    }

    if ($lastpage < 7 + ($adjacents * 2)) {
        for ($counter = 1; $counter <= $lastpage; $counter++) {
            if ($counter == $page) {
                $pagination .= "<li class=\"page-item active\"><a href='#' class=\"page-link\">$counter</a></li>";
            } else {
                $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$counter\" class=\"page-link\">$counter</a></li>";
            }

        }
    } elseif ($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
    {
//close to beginning; only hide later pages
        if ($page < 1 + ($adjacents * 2)) {
            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                if ($counter == $page) {
                    $pagination .= "<li class=\"page-item active\"><a href='#' class=\"page-link\">$counter</a></li>";
                } else {
                    $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$counter\" class=\"page-link\">$counter</a></li>";
                }

            }
            $pagination .= "<li class=\"page-item\">...</li>";
            $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$lpm1\" class=\"page-link\">$lpm1</a></li>";
            $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$lastpage\" class=\"page-link\">$lastpage</a></li>";
        }
//in middle; hide some front and some back
        elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
            $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=1\" class=\"page-link\">1</a></li>";
            $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=2\" class=\"page-link\">2</a></li>";
            $pagination .= "<li class=\"page-item\">...</li>";
            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                if ($counter == $page) {
                    $pagination .= "<li class=\"page-item active\"><a href='#' class=\"page-link\">$counter</a></li>";
                } else {
                    $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$counter\" class=\"page-link\">$counter</a></li>";
                }

            }
            $pagination .= "<li class=\"page-item\">...</li>";
            $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$lpm1\" class=\"page-link\">$lpm1</a></li>";
            $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$lastpage\" class=\"page-link\">$lastpage</a></li>";
        }
//close to end; only hide early pages
        else {
            $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=1\" class=\"page-link\">1</a></li>";
            $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=2\" class=\"page-link\">2</a></li>";
            $pagination .= "<li class=\"page-item\">...</li>";
            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage;
                $counter++) {
                if ($counter == $page) {
                    $pagination .= "<li class=\"page-item active\"><a href='#' class=\"page-link\">$counter</a></li>";
                } else {
                    $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$counter\" class=\"page-link\">$counter</a></li>";
                }

            }
        }
    }

//next button
    if ($page < $counter - 1) {
        $pagination .= "<li class=\"page-item\"><a href=\"$targetpage?page=$next\" class=\"page-link\">&rsaquo;</a></li>";
    } else {
        $pagination .= "";
    }

    $pagination .= "</ul></div>\n";
}
