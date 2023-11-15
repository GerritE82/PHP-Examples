<?php

	/*
		This Class mimics certain features of C#'s Console Class and was meant to reduce switching back & forth between php/html.
	*/

    class Console
    {
        // ADD COLOR TO TEXT
        public static function StringColor($string, $color)
        {
            return "<span style='color: $color'>$string</span>";
        }

        // SHOWS DATE AND TIME IN SHORTHAND TEXT WITH SOME FORMATTING
        public static function ShowDate()
        {
            ?>
                <div class="showdate">
                    <?php
                        $datetime = date('[D j M - H:i:s]');
                        echo Self::StringColor($datetime, 'darkgray') . '<br>' . Self::StringColor(str_repeat("=", strlen($datetime)), 'darkgray'); 
                    ?>
                </div>
            <?php
        }

        // WRITES STRING TO SCREEN IN SINGLE LINE AND GOES TO NEXT
        public static function WriteLine($string)
        {
            echo $string . '<br>';
        }

        // CREATES AND EMPTY LINE
        public static function NewLine($num=1)
        {
            for($i=0; $i<$num; $i++)
            {
                Self::WriteLine("");
            }
        }
        
        // CREATES HTML FORM WITH USER SPECIFIED ACTION & INPUTFIELD & HIDES SUBMIT BUTTON
        public static function SearchBar($action)
        {
            ?>
                <form action="<?php echo htmlspecialchars($action); ?>" method="POST">
                    Search Item: <input type="text" name="search_input" placeholder="" autocomplete="off" spellcheck="false" width="100%">
                    <input type="submit" name="submit" value="[search]" style="display: none;">
                </form>
            <?php
        }

        // CREATES AN HTML HYPERLINK WITH NESTED BUTTON
        public static function Button($name, $action="#")
        {
            ?>
                <a href="<?php echo htmlspecialchars($action); ?>">
                    <button><?php echo $name; ?></button>
                </a>
            <?php
        }

        // CREATES AN HTML FORM WITH SUBMIT BUTTON & A HIDDEN ID VALUE
        public static function ButtonSendID($name, $action="#", $id="")
        {
            ?>
                <form action="<?php echo htmlspecialchars($action); ?>" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <input type="submit" name="submit" value="<?php echo htmlspecialchars($name); ?>">
                </form>
            <?php
        }

        // ==========================================================[TABLES]
        // MARKS THE START OF AN HTML TABLE
        public static function TableStart()
        {
            ?> <table> <?php
        }

        // MARKS THE END OF AN HTML TABLE
        public static function TableEnd()
        {
            ?> </table> <?php
        }

        // MARKS THE START OF AN HTML TABLE ROW
        public static function RowStart()
        {
            ?> <tr> <?php
        }

        // MARKS THE END OF AN HTML TABLE ROW
        public static function RowEnd()
        {
            ?> </tr> <?php
        }

        // MARKS THE START OF AN HTML TABLE CELL & ALLOWS ALIGNMENT OPTION
        public static function CellStart($alignment="right")
        {
            ?> <td style="text-align: <?php echo htmlspecialchars($alignment); ?>"> <?php
        }

        // MARKS THE END OF AN HTML TABLE CELL
        public static function CellEnd()
        {
            ?> </td> <?php
        }

        // ==========================================================[DEBUGGING]
        public static function PrintAssoc($array)
        {
            Console::TableStart();
            Console::RowStart();
                Console::CellStart("left");
                    echo Self::StringColor("KEY:", "goldenrod");
                Console::CellEnd();
                Console::CellStart();
                Console::CellEnd();
                Console::CellStart("left");
                    echo Self::StringColor("VALUE:", "goldenrod");
                Console::CellEnd();
            Console::RowEnd();
            foreach($array as $key => $value)
            {
                Console::RowStart();
                    Console::CellStart("left");
                        echo htmlspecialchars($key);
                    Console::CellEnd();
                    Console::CellStart("left");
                        echo "=>";
                    Console::CellEnd();
                    Console::CellStart("left");
                        echo htmlspecialchars($value);
                    Console::CellEnd();
                Console::RowEnd();
            }
            Console::TableEnd();
        }
    }
?>