function validateRemainder(f)
{
    var datetime=f.reminderdate.value;

    var description = f.reminder.value;

    if(description == "" ||description == " " ||description == "  " ||description == "    ")
    {
        inlineMsg('reminder','You must Enter the description...',4);

        return false;
    }

    if(datetime=="" ||datetime==" " ||datetime=="  " ||datetime=="   " ||datetime=="     " )
    {
        inlineMsg('reminderdate','You must Enter Date....',4);

        return false;
    }

    return true;

}


