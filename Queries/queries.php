<?php
    // $conn established elsewhere
    // -----------------------------------------------------------[ QUIZ RELATED FUNCTIONS ]
    // GETS ALL QUIZZES THAT ARE SET TO PUBLIC
    function get_public_quizzes($conn)
    {
        $sql = 'SELECT * FROM quizzes WHERE ispublic = ?';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt, [1]);
        
        return mysqli_stmt_get_result($stmt);
    }

    // GETS QUIZ BY QUIZ ID
    function get_quiz($conn, $id)
    {
        $sql = 'SELECT * FROM quizzes WHERE id = ?';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt, [$id]);
        
        return mysqli_stmt_get_result($stmt);
    }

    // GETS QUIZ CATEGORY
    function get_category($conn, $id)
    {
        $stmt = mysqli_prepare($conn, "SELECT name FROM categories WHERE id = ?");
        mysqli_stmt_execute($stmt, [$id]);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row['name'];
    }

    // GET QUIZZES BY USER
    function get_quizzes_by_userid($conn, $id)
    {
        $sql = 'SELECT * FROM quizzes WHERE user_id = ?';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt, [$id]);
        
        return mysqli_stmt_get_result($stmt);
    }

    // GET NUMBER OF QUIZZES BY USER ID
    function get_quiz_count_by_id($conn, $id)
    {
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM quizzes WHERE user_id = ?");
        mysqli_stmt_execute($stmt, [$id]);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_row($result);
        $count = $row[0];
        
        return $count;
    }

    // GET ACCESSIBILITY OF QUIZ
    function is_public($conn, $id)
    {
        $stmt = mysqli_prepare($conn, "SELECT ispublic FROM quizzes WHERE id = ?");
        mysqli_stmt_execute($stmt, [$id]);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row['ispublic'];
    }

    // GET CATEGORIES WITH 'DEFAULT' AS FIRST ITEM AND REST IN ALPHABETICAL ORDER
    function get_categories($conn)
    {
        $sql = "SELECT * FROM categories ORDER BY (name = 'default') DESC, name ASC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        
        return mysqli_stmt_get_result($stmt);
    }

    // GETS RATING OF QUIZ WITH SPECIFIC ID
    function get_rating($conn, $id)
    {
        $averageRating = null;

        $sql = "SELECT AVG(rating) FROM ratings WHERE quiz_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt,[$id]);

        mysqli_stmt_bind_result($stmt, $averageRating);
        mysqli_stmt_fetch($stmt);

        if ($averageRating !== null) 
        {
            return number_format($averageRating, 1);
        }
        else
        {
            return "Not yet rated";
        }
    }

    // GETS OWNER OF THE QUIZ WITH SPECIFIC QUIZ ID
    function get_quiz_owner($conn, $quizid)
    {
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM quizzes WHERE id = ?");
        mysqli_stmt_execute($stmt, [$quizid]);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $username = get_username_by_id($conn, $row['user_id']);
        return $username;
    }

    // -----------------------------------------------------------[ USER RELATED FUNCTIONS ]

    // GETS USER BY SPECIFIC ID
    function get_user_by_id($conn, $id)
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt, [$id]);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }
    
    // GETS USER BY SPECIFIC NAME
    function get_user_by_name($conn, $name)
    {
        $sql = 'SELECT * FROM users WHERE username = ?';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt, [$name]);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }
    
    // GETS USER DISPLAY NAME BY SPECIFIC ID
    function get_displayname_by_id($conn, $id)
    {
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
        mysqli_stmt_execute($stmt, [$id]);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row['displayname'];
    }

    // GETS USER NAME BY SPECIFIC ID
    function get_username_by_id($conn, $id)
    {
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
        mysqli_stmt_execute($stmt, [$id]);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row['username'];
    }

    // GETS USER ID BY SPECIFIC NAME
    function get_user_id_by_name($conn, $name)
    {
        $sql = 'SELECT id FROM users WHERE username = ?';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt, [$name]);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result)['id'];
    }

    // GETS USER BY SPECIFIC DISPLAYNAME
    function get_user_by_displayname($conn, $displayname)
    {
        $sql = 'SELECT * FROM users WHERE displayname = ?';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt, [$displayname]);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    // ADDS USER TO TABLE
    function add_user($conn, $name, $displayname, $password)
    {
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, displayname, password) Values (?,?,?)");
        mysqli_stmt_execute($stmt, [$name, $displayname, $hashedPass]);
    }
?>
