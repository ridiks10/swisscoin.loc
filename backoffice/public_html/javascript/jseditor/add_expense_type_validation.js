function addExpenseTypes(f)
{
    var exp_type=f.exp_type.value;

    if(check(exp_type))
    {

        inlineMsg('exp_type','You must Enter  new expense...',4);

        return false;
    }
    return true;
}


function validateAddExpense(f1)
{
    var numberRegex = /^[0-9]+/;

    var amount=f1.amount.value;

    var exp_type=f1.exp_type.value;

    var date=f1.date.value;

    if(check(amount))
    {
        inlineMsg('amount','You must Enter  Amount...',4);

        return false;
    }

    if(!amount.match(numberRegex))
    {
        inlineMsg('amount','Enter a integer.',2);

        return false;
    }

    if(exp_type=="")
    {
        inlineMsg('exp_type','Select Expense Type.',2);

        return false;
    }

    if(date=="")
    {
        inlineMsg('date','You must enter date...',1);

        return false;
    }


    return true;
}





function check(a)
{
    var flg =true;

    var i=0;

    if(a =="")
    {
        return true;
    }
    else
    {
        while(i<a.length)
        {
            if((a.charAt(i)!=' ' ))
            {
                flg = false;

            }
            i++;
        }
    }
    return flg;
}

