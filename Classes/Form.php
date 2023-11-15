<?php

    include_once __DIR__ . "/../classes/console.php";
	
	/*
		Form Builder prototype
	*/

    class Form
    {
        private $name;
        private $action;
        private $method;
        private $fields = [];

        public function __construct($name, $action, $method="POST")
        {
            $this->name = $name;
            $this->action = $action;
            $this->method = $method;
        }

        public function AddField($name, $type="text", $value="", $comment="")
        {
            $field = new Field($name, $type, $value, $comment);
            $this->fields[] = $field;
        }

        public function Publish()
        {
            if($this->name !== '')
            {
                Console::WriteLine(strtoupper($this->name));
                Console::WriteLine(Console::StringColor(str_repeat("─", 50), "darkgray"));
                Console::NewLine();
            }

            ?>
                <form action="<?php echo htmlspecialchars($this->action); ?>" method="<?php echo htmlspecialchars($this->method); ?>">
                    <?php foreach($this->fields as $field){ $this->PublishField($field); } ?>
                    <input type="hidden" name="submit" value="submit">
                    <button type="submit" class="loginsubmit">[submit]</button>
                </form>
            <?php
        }

        private function PublishField($field)
        {
            $comment = Console::StringColor(($field->GetComment() !== '') ? " (" . $field->GetComment() . ")" : "", "dimgray");
            Console::WriteLine($this->FormatName($field->GetName()) . $comment . ':');
            ?>
                <input type="<?php echo $field->GetType(); ?>" name="<?php echo $field->GetName(); ?>" value="<?php echo $field->GetValue(); ?>" autocomplete="off" spellcheck="false" width="100%"><br>
            <?php
        }

        private function FormatName($name)
        {
            return strtoupper(str_replace('_', ' ', $name));
        }
    }

    class Field
    {
        private $name;
        private $type;
        private $value;
        private $comment;
        private $errorMessage;

        public function __construct($name, $type, $value, $comment)
        {
            $this->name = $name;
            $this->type = $type;
            $this->value = $value;
            $this->comment = $comment;
        }

        public function GetName()
        {
            return $this->name;
        }

        public function GetType()
        {
            return $this->type;
        }

        public function GetValue()
        {
            return $this->value;
        }

        public function GetComment()
        {
            return $this->comment;
        }

        public function GetError()
        {
            return $this->errorMessage;
        }
    }
?>