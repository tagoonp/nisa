args <- commandArgs(TRUE)

SESSION_ID <- args[1]
UID <- args[2]

library(epicalc)
library(ggplot2)
library(tidyverse)
library(jsonlite)


setwd('/var/www/html/nisa/img')

data_url = paste("http://simanh.psu.ac.th/nisa/controller/get_json_data.php?session=", SESSION_ID)
quandl_data <- fromJSON(data_url)
df <- as.data.frame(quandl_data)
use(df)
df
df %>% pull(1) -> dfX
df %>% select(1,3) -> dfSIR
df %>% pull(3) -> dSIR
df %>% pull(8) -> DS
df %>% pull(9) -> DW
df %>% pull(10) -> DC

color_group <- rep(c("blue","yellow","blue","red"), 1)
graph1 <- ggplot(data=df, aes(x=X, y=SIR, group = 1)) +
  geom_line(aes(x=X,y=CL), color = 'red', group = 1, linetype = "dashed", size=1) +
  geom_line(aes(x=X,y=SIR), color = 'blue', group = 2, size = 1) +
  geom_point(aes(y=SIR), color = DC , group = 3, shape = DS, size = DW) +
  labs(
    title = "SPC chart of CLABSI SIR",
    x = "Quarter of the year",
    y = "SIR of CLABSI"
  )

filename_output = paste(SESSION_ID, ".wmf")
win.metafile(filename=filename_output)
plot(graph1)

dev.off()
