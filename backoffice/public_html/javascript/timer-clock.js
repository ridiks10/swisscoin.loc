    $(document).ready(function(){
    
      $.clock.locale = {"pt":{"weekdays":["Domingo","Segunda-feira", "Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira", "Sábado"],"months":["Janeiro","Fevereiro","Março","Abril", "Maio","Junho","Julho","Agosto","Setembro","October","Novembro", "Dezembro"] } };
      
      $("#clock1").clock();
      $("#clock2").clock({"langSet":"it"});
      $("#clock3").clock({"langSet":"pt"});
      $("#clock4").clock({"format":"24","calendar":"false"});
      
      customtimestamp = new Date();
      customtimestamp = customtimestamp.getTime();
      customtimestamp = customtimestamp+1123200000+10800000+14000;
      $("#clock5").clock({"timestamp":customtimestamp});

                                           
    }); 
