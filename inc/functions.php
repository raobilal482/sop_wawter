<?php
include "config.php";
class func extends db
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getsingleuserdetails($userId)
    {
        $sql = "SELECT u.*, p.*
                FROM water_users u
                LEFT JOIN water_user_payments p ON u.id = p.user_id
                WHERE u.id = :userId
                ORDER BY CONCAT(p.payment_year, LPAD(p.payment_month, 2, '0')) DESC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $userWithPayments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userWithPayments;
    }
    public function checkAlreadyAddedPayments($table, $month, $year)
    {
        $monthname = '';
        $yearname = '';
        if ($table == 'water_expenses') {
            $monthname = 'month_expenses';
            $yearname = 'year_expenses';
        } elseif ($table == 'water_user_payments') {
            $monthname = 'payment_month';
            $yearname = 'payment_year';
        } else {
            return false;
        }
        $sql = "SELECT * FROM $table WHERE $monthname = :month AND $yearname = :year";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getAllRecords(
        $table,
        $where = null,
        $countUniqueMonths = false,
        $countallyears = false
    ) {
        if ($countUniqueMonths) {
            $sql = "SELECT COUNT(DISTINCT payment_month) AS total_unique_months FROM $table";
        } elseif ($countallyears) {
            $sql = " SELECT COUNT(DISTINCT payment_year) AS total_years FROM $table";
        } else {
            $sql = "SELECT * FROM $table";
        }
        if ($where !== null && !$countUniqueMonths && !$countallyears) {
            $sql .= " WHERE $where";
        }
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        if ($countUniqueMonths) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_unique_months'];
        } elseif ($countallyears) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_years'];
        } else {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }
    }
    public function insertRecords($table, $data = [], $email = null, $extra = null)
    {
        if ($extra != null) {
            $sql = "SELECT * FROM $table WHERE admin_email = :email";
            $datas = $this->mysqli->prepare($sql);
            $datas->bindValue(':email', $email);
            $datas->execute();
            if ($datas->fetch(PDO::FETCH_ASSOC)) {
                return false;
            } else {
                $values = array_values($data);
                $placeholders = implode(', :', array_keys($data));
                $sql = "INSERT INTO $table (" . implode(', ', array_keys($data)) . ")
                VALUES (:" . $placeholders . ")";
                $stmt = $this->mysqli->prepare($sql);
                foreach ($data as $key => $value) {
                    $stmt->bindValue(':' . $key, $value);
                }
                $stmt->execute();
                $lastInsertId = $this->mysqli->lastInsertId();
                $sql = "SELECT * FROM $table WHERE id = :id";
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bindValue(':id', $lastInsertId);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            $values = array_values($data);
            $placeholders = implode(', :', array_keys($data));
            $sql = "INSERT INTO $table (" . implode(', ', array_keys($data)) . ")
            VALUES (:" . $placeholders . ")";
            $stmt = $this->mysqli->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
            $lastInsertId = $this->mysqli->lastInsertId();
            $sql = "SELECT * FROM $table WHERE id = :id";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bindValue(':id', $lastInsertId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function getAllNextRecords($table, $current_id, $user_id, $year)
    {
        $sql = "SELECT * FROM $table WHERE user_id = :user_id AND id > :current_id AND payment_year >= :payment_year ORDER BY payment_month ASC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':current_id', $current_id, PDO::PARAM_INT);
        $stmt->bindParam(':payment_year', $year, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getallpaymentsforupdate($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE user_id = $id";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getSingleRecord($table, $id = null, $email = null, $password = null)
    {
        if ($id != null) {
            $sql = "SELECT * FROM $table WHERE id=$id";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } elseif ($email != null) {
            $sql = "SELECT * FROM $table WHERE admin_email='$email' AND password='$password'";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->execute();
            if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                return $result;
            } else {
                return false;
            }
        }
    }
    public function deleteRecord($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id=$id";
        $stmt = $this
            ->mysqli
            ->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function updaterecords($table, $updatevalues, $id)
    {
        $keys = array_keys($updatevalues);
        $setClause = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, $keys));
        $sql = "UPDATE $table SET $setClause WHERE id = :id";
        $stmt = $this->mysqli->prepare($sql);
        foreach ($updatevalues as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':id', $id);
        if ($stmt->execute()) {
            $sql_select = "SELECT * FROM $table WHERE id = :id";
            $stmt_select = $this->mysqli->prepare($sql_select);
            $stmt_select->bindValue(':id', $id);
            $stmt_select->execute();
            return $stmt_select->fetch(PDO::FETCH_ASSOC);
        } else {
            return 'Error While Updating record';
        }
    }
    public function updateallrecords($table, $user_id, $month, $year)
    {
        $sql_select = "SELECT * FROM $table WHERE user_id = :user_id AND (payment_year > :payment_year OR (payment_year = :payment_year AND payment_month >= :payment_month)) ORDER BY payment_year, payment_month";
        $stmt_select = $this->mysqli->prepare($sql_select);
        $stmt_select->bindValue(':user_id', $user_id);
        $stmt_select->bindValue(':payment_month', $month);
        $stmt_select->bindValue(':payment_year', $year);
        $stmt_select->execute();
        $allData = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        return $allData;
    }
    // public function payments($month, $year, $rate)
    // {
    //     $khati = 0;
    //     $records = $this->getAllRecords('water_users');
    //     foreach ($records as $record) {
    //         $user_id = $record['id'];
    //         $water_hours = $record['water_hours'];
    //         $water_current_bill = $water_hours * $rate;
    
    //         // Check if current month's payment already exists
    //         $alreadyAddedPayment = $this->checkAlreadyAddedPayments('water_user_payments', $month, $year);
    //         var_dump(['already added' => $alreadyAddedPayment]);
    //         if (!empty($alreadyAddedPayment)) {
    //             return "Payment for this month is already added.";
    //         }
    
    //         // Check if previous month's payment exists, except for January
    //         if ($month != 1) {
    //             $previous_remaining = $this->getPreviousRemaining($user_id, $month, $year);
    //             if (empty($previous_remaining)) {
    //                 $previous_month_name = date("F", mktime(0, 0, 0, $month - 1, 1, $year));
    //                 return "Please add the payment for " . $previous_month_name . " before adding payments for " . $month;
    //             }
    //         }
    
    //         // Proceed with inserting payments
    //         $t_bill = $khati + $water_current_bill;
    //         $outstandings = $t_bill + $previous_remaining;
    
    //         $stmt = $this->mysqli->prepare("INSERT INTO water_user_payments
    //                                 (user_id, payment_month, payment_year, water_hours, water_rate, water_current_bill, water_khati, water_total_bill, outstandings, remaining, ts)
    //                                 VALUES
    //                                 (:user_id, :payment_month, :payment_year, :water_hours, :water_rate, :water_current_bill, :water_khati, :water_total_bill, :outstandings, :remaining, :ts)");
    //         $stmt->bindParam(':user_id', $user_id);
    //         $stmt->bindParam(':payment_month', $month);
    //         $stmt->bindParam(':payment_year', $year);
    //         $stmt->bindParam(':water_hours', $water_hours);
    //         $stmt->bindParam(':water_rate', $rate);
    //         $stmt->bindParam(':water_current_bill', $water_current_bill);
    //         $stmt->bindParam(':water_khati', $khati);
    //         $stmt->bindParam(':water_total_bill', $t_bill);
    //         $stmt->bindParam(':outstandings', $outstandings);
    //         $stmt->bindParam(':remaining', $previous_remaining);
    //         $current_date = date('Y-m-d H:i:s');
    //         $stmt->bindParam(':ts', $current_date);
    //         $stmt->execute();
    //     }
    //     return true;
    // }
    

    public function payments($month, $year, $rate)
    {
        $khati = 0;
        $records = $this->getAllRecords('water_users');
        foreach ($records as $record) {
            $user_id = $record['id'];
            $water_hours = $record['water_hours'];
            $water_current_bill = $water_hours * $rate;
            $previous_remaining = $this->getPreviousRemaining($user_id, $month, $year);
            $t_bill = $khati + $water_current_bill;
            $outstandings = $t_bill + $previous_remaining;
            $stmt = $this->mysqli->prepare("INSERT INTO water_user_payments
                                    (user_id, payment_month, payment_year, water_hours, water_rate, water_current_bill, water_khati, water_total_bill, outstandings, remaining, ts)
                                    VALUES
                                    (:user_id, :payment_month, :payment_year, :water_hours, :water_rate, :water_current_bill, :water_khati, :water_total_bill, :outstandings, :remaining, :ts)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':payment_month', $month);
            $stmt->bindParam(':payment_year', $year);
            $stmt->bindParam(':water_hours', $water_hours);
            $stmt->bindParam(':water_rate', $rate);
            $stmt->bindParam(':water_current_bill', $water_current_bill);
            $stmt->bindParam(':water_khati', $khati);
            $stmt->bindParam(':water_total_bill', $t_bill);
            $stmt->bindParam(':outstandings', $outstandings);
            $stmt->bindParam(':remaining', $previous_remaining);
            $current_date = date('Y-m-d H:i:s');
            $stmt->bindParam(':ts', $current_date);
            $stmt->execute();
        }
        return true;
    }
    public function getPreviousRemaining($user_id, $month, $year)
    {
        $stmt = $this->mysqli->prepare("SELECT outstandings
                               FROM water_user_payments
                               WHERE user_id = :user_id
                                 AND (
                                   (payment_year = :year AND payment_month = :month - 1)
                                   OR
                                   (payment_year = :year - 1 AND payment_month = 12 AND :month = 1)
                                 )
                               ORDER BY ts DESC
                               LIMIT 1");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['outstandings'] : 0;

    }
    public function date_dbconvert($date)
    {
        return date("Y-m-d", strtotime($date));
    }
    public function date_convert($date_added)
    {
        if ($date_added != '1970-01-01' && $date_added != '0000-00-00') {
            return date("d-m-Y", strtotime($date_added));
        }
    }
    public function showpayments($month = null, $year = null)
    {
        $fresult = "";
        $remains = [];
        if ($month == null && $year == null) {
            $data = $this->mysqli->prepare("SELECT water_user_payments.*,
         water_users.user_name
         FROM water_user_payments
        INNER JOIN water_users ON water_user_payments.user_id = water_users.id");
        } else {
            $data = $this->mysqli->prepare("SELECT water_user_payments.*,
        water_users.user_name
        FROM water_user_payments
       INNER JOIN water_users ON water_user_payments.user_id = water_users.id WHERE payment_month = '$month' AND payment_year='$year'");
        }
        $data->execute();
        $row = $data->fetchAll(PDO::FETCH_ASSOC);
        $getremain = $this->getAllRecords('water_user_payments_status_history');
        foreach ($getremain as $remain) {
            $remains[] = $remain['user_remaining_amount'];
        }
        $snn = 1;
        foreach ($row as $key => $pay) {
            $tbill = $pay['water_current_bill'];
            $poutstandings = $pay['outstandings'];
            $outstandings = $poutstandings;
            if ($outstandings < 0) {
                $outstandings = '<span style="color:green; font-weight: bolder;">+' . abs($outstandings) . '</span>';
            };
            if ($outstandings > 0) {
                $outstandings = '<span style="color:red; font-weight: bolder;" >' . $outstandings . '</span>';
            }
            $fresult .= '<tr class="gradeX">
                        <td>' . $snn . '</td>
                        <td>' . $pay['payment_month'] . '/' . $pay['payment_year'] . '</td>
                        <td>' . $pay['user_name'] . '</td>
                        <td >' . $pay['water_hours'] . '</td>
                        <td>' . $pay['water_rate'] . '</td>
                        <td>' . $pay['water_current_bill'] . ' </td>
                        <td >
                         <div style="display:flex">' . $pay['water_khati'] .
                '<a href="#" class=" disableOnUpdate btn khatieditBtn" id="openkhatibtn" data-id=' . $pay['id'] . '>
                         <i data-bs-toggle="modal" data-bs-target="#khatiModal" class="bx bx-plus" aria-hidden="true">
                         </i>
                          </a>
                          </div>
                          </td>
                        <td> ' . $pay['remaining'] . ' </td>
                        <td>' . $pay['water_total_bill'] . '</td>
                        <td> ' . $pay['received_amount'] . '</td>
                        <td> ' . $outstandings . '   </td>
                        <td> <a href="#" class=" btn editBtn" id=' . $pay['id'] . '> <i data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="bx bx-edit "></i> </a></td>
                        </tr>';
            $snn++;
        }
        return $fresult;
    }
    public function getLastInsertedPaymentMonth()
    {
        $lastId = 0;
        $data = $this->mysqli->prepare("SELECT payment_month FROM water_user_payments ORDER BY payment_month DESC LIMIT 1");
        $data->execute();
        $row = $data->fetch(PDO::FETCH_ASSOC);
        if ($row && isset($row['payment_month'])) {
            $lastpaymentmonth = $row['payment_month'];
        }
        return $lastpaymentmonth;
    }
    public function getLastInsertedUserId()
    {
        $lastId = 0;
        $data = $this->mysqli->prepare("SELECT id FROM water_users ORDER BY id DESC LIMIT 1");
        $data->execute();
        $row = $data->fetch(PDO::FETCH_ASSOC);
        if ($row && isset($row['id'])) {
            $lastid = $row['id'];
        }
        return $lastid;
    }
    public function getSingleRecordByConditions($table, $userid, $paymentmonth, $paymentyear)
    {
        $sql = "SELECT * FROM $table WHERE user_id = ? AND payment_month = ? AND payment_year = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute([$userid, $paymentmonth, $paymentyear]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return $record;
    }
    public function updatemainlogic($table, $updatevalues, $userid, $paymentmonth, $paymentyear)
    {
        $getvalues = [];
        $keys = array_keys($updatevalues);
        $values = array_values($updatevalues);
        $secvalues = array_map(function ($keys) {
            return $keys . " = :" . $keys;
        }, $keys);
        $finalvalues = implode(', ', $secvalues);
        $sql = "UPDATE $table SET $finalvalues WHERE user_id=:id AND payment_month=:payment_month AND payment_year =:payment_year";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bindValue(':id', $userid);
        $stmt->bindValue(':payment_month', $paymentmonth);
        $stmt->bindValue(':payment_year', $paymentyear);
        foreach ($updatevalues as $ke => $val) {
            $stmt->bindValue(":$ke", $val);
        }
        if ($stmt->execute()) {
            return "update successfully";
        } else {
            return "query execution problem";
        }
    }
    public function updateOutstandingsRecursively($obj, $userid, $paymentmonth, $paymentyear, $outstandings)
    {
        $updateSuccess = $obj->updatemainlogic('water_user_payments', $outstandings, $userid, $paymentmonth, $paymentyear);
        if (!$updateSuccess) {
            return false;
        }
        if ($paymentmonth == 12) {
            $nextYear = $paymentyear + 1;
            $nextMonth = 1;
        } else {
            $nextYear = $paymentyear;
            $nextMonth = $paymentmonth + 1;
        }
        $nextMonthData = $obj->getSingleRecordByConditions('water_user_payments', $userid, $nextMonth, $nextYear);
        if ($nextMonthData) {
            $nextMonthData['remaining'] += $outstandings['received_amount'];
            $nextMonthData['water_total_bill'] += $outstandings['received_amount'];
            $nextMonthData['outstandings'] = $nextMonthData['water_total_bill'] - $nextMonthData['received_amount'];
            $nextMonthUpdateData = [
                'remaining' => $nextMonthData['remaining'],
                'water_total_bill' => $nextMonthData['water_total_bill'],
                'outstandings' => $nextMonthData['outstandings'],
                'nt' => 1,
            ];
            $obj->updatemainlogic('water_user_payments', $nextMonthUpdateData, $userid, $nextMonth, $nextYear);
            updateOutstandingsRecursively($obj, $userid, $nextMonth, $nextYear, $nextMonthUpdateData);
        }
        return true;
    }
    public function getSubsequentRecords($table, $userid, $paymentmonth, $paymentyear)
    {
        $sql = "SELECT * FROM $table WHERE user_id = :userid AND (payment_year > :payment_year OR (payment_year = :payment_year AND payment_month > :payment_month))";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bindValue(':userid', $userid);
        $stmt->bindValue(':payment_year', $paymentyear);
        $stmt->bindValue(':payment_month', $paymentmonth);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function firstyear($result, $allmonths, $allyears, $year = null)
    {
        for ($y = $result['payment_year']; $y <= $allyears + 2021; $y++) {
            if ($year != null) {
                $k = 1;
            } else {
                $k = $result['payment_month'];
            }
            for ($i = $k; $i <= $allmonths; $i++) {
                $userid = $result['user_id'];
                $paymentmonth = $i;
                if ($year != null) {
                    $paymentyear = $year;
                } elseif ($year == null) {
                    $paymentyear = $result['payment_year'];
                }
                $currentmonth = $this->getSingleRecordByConditions('water_user_payments', $userid, $paymentmonth, $paymentyear);
                if ($currentmonth['nt'] == 1) {
                    $currentmonth['water_total_bill'] -= $currentmonth['remaining'];
                }
                if ($paymentmonth == 1 && $paymentyear == 2022) {
                    $remaining = 0;
                } elseif ($paymentmonth == 1 && $paymentyear != 2022) {
                    $remaining = $currentmonth['remaining'];
                } elseif ($paymentmonth != 1 && $paymentyear != 2022) {
                    $previousmonth = $this->getSingleRecordByConditions('water_user_payments', $userid, $paymentmonth - 1, $paymentyear);
                    $remaining = $previousmonth['outstandings'];
                } else {
                    $previousmonth = $this->getSingleRecordByConditions('water_user_payments', $userid, $paymentmonth - 1, $paymentyear);
                    $remaining = $previousmonth['outstandings'];
                }
                $currentmonth['remaining'] = $remaining;
                $currentmonth['water_total_bill'] += $currentmonth['remaining'];
                $currentmonth['outstandings'] = $currentmonth['water_total_bill'] - $currentmonth['received_amount'];
                $updateData = [
                    'remaining' => $remaining,
                    'water_total_bill' => $currentmonth['water_total_bill'],
                    'outstandings' => $currentmonth['outstandings'],
                    'nt' => 1,
                ];
                $udate = $this->updatemainlogic('water_user_payments', $updateData, $userid, $paymentmonth, $paymentyear);
            }
            return $year;
        }
    }
    public function nextyear($result, $allmonths, $allyears)
    {
        for ($y = $result['payment_year']; $y <= $allyears + 2021; $y++) {
            $userid = $result['user_id'];
            $nextyear = $y + 1;
            $nextyearcurrentmonth = $this->getSingleRecordByConditions('water_user_payments', $userid, 1, $nextyear);
            if ($nextyearcurrentmonth['nt'] == 1) {
                $nextyearcurrentmonth['water_total_bill'] -= $nextyearcurrentmonth['remaining'];
            }
            $nextyearpreviousmonth = $this->getSingleRecordByConditions('water_user_payments', $userid, 12, $nextyear - 1);
            $remaining = $nextyearpreviousmonth['outstandings'];
            $nextyearcurrentmonth['remaining'] = $remaining;
            $nextyearcurrentmonth['water_total_bill'] += $nextyearcurrentmonth['remaining'];
            $nextyearcurrentmonth['outstandings'] = $nextyearcurrentmonth['water_total_bill'] - $nextyearcurrentmonth['received_amount'];
            $againupdateData = [
                'remaining' => $remaining,
                'water_total_bill' => $nextyearcurrentmonth['water_total_bill'],
                'outstandings' => $nextyearcurrentmonth['outstandings'],
                'nt' => 1,
            ];
            $udate = $this->updatemainlogic('water_user_payments', $againupdateData, $userid, 1, $nextyear);
            $data = $this->firstyear($result, $allmonths, $nextyear, $allyears);
        }
        return $allyears;
    }
    public function getRecordsforHistory($table, $month, $year, $user)
    {
        $sql = "SELECT t1.*, t2.user_name
            FROM $table t1
            INNER JOIN water_users t2 ON t1.user_id = t2.id ";
        $whereClause = [];
        if ($month != '*') {
            $whereClause[] = "t1.payment_month = :month";
        }
        if ($year != '*') {
            $whereClause[] = "t1.payment_year = :year";
        }
        if ($user != '*') {
            $whereClause[] = "t1.user_id = :user";
        }
        if (!empty($whereClause)) {
            $sql .= "WHERE " . implode(" AND ", $whereClause);
        }
        $sql .= " ORDER BY t1.payment_month DESC, t1.payment_year DESC";
        $stmt = $this->mysqli->prepare($sql);
        if ($month != '*') {
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        }
        if ($year != '*') {
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        }
        if ($user != '*') {
            $stmt->bindParam(':user', $user, PDO::PARAM_INT);
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getexpensesforHistory($table, $month, $year)
    {
        if ($month != '*' and $year != '*') {
            $sql = "SELECT * FROM $table WHERE
       month_expenses = $month AND year_expenses = $year";
        } elseif ($month == '*' and $year != '*') {
            $sql = "SELECT * FROM $table WHERE year_expenses = $year";
        } elseif ($month != '*' and $year == '*') {
            $sql = "SELECT * FROM $table WHERE month_expenses = $month";
        } elseif ($month == '*' and $year == '*') {
            $sql = "SELECT * FROM $table";
        }
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function dashboard($usertable)
    {
        $sql = "SELECT COUNT(*) as len FROM $usertable";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getAllbill()
    {
        // Select the sum of water_total_bill
        $sql = 'SELECT SUM(water_total_bill) AS total_bill FROM water_user_payments';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $bill = $stmt->fetch(PDO::FETCH_ASSOC);
        $sql = 'SELECT SUM(received_amount) AS received_amount FROM water_user_payments';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $received_amount = $stmt->fetch(PDO::FETCH_ASSOC);
        $sql = 'SELECT SUM(outstandings) AS outstandings FROM water_user_payments';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $outstandings = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result = [
            'outstandings' => $outstandings,
            'bill' => $bill,
            'received_amount' => $received_amount,
        ];
    }

}
